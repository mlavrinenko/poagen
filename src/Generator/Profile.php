<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

use Mlavrinenko\Paogen\Generator\Naming\NameNormaliser;

/**
 * User-supplied generation guidance. See `profile-driven-generation` /
 * `typed-profile-and-colocated-attributes`.
 *
 * Pure value object: parsed by the generator, never executed.
 */
final readonly class Profile
{
    /**
     * @param string                $schema         Path to the OpenAPI YAML/JSON file.
     * @param string                $output         Output directory for generated PHP.
     * @param string                $namespace      Root namespace for generated classes (no trailing backslash).
     * @param list<string>          $discoverIn     Namespace prefixes to scan for #[Binds*] attributes.
     * @param array<string,string>  $renames        Map of schema-component name → desired PHP class name.
     *                                              Always honoured before the auto-sanitiser.
     * @param NameNormaliser|null   $nameNormaliser Custom normalisation pipeline. When null, paogen
     *                                              composes RenamesNormaliser($renames) + PascalCaseSanitiser.
     *                                              When set, paogen uses it verbatim — `$renames` is *not*
     *                                              merged in automatically. See
     *                                              `typed-profile-and-colocated-attributes` (T-023).
     * @param array<string,string>  $discriminators Override map for undiscriminated property-level
     *                                              `oneOf`/`anyOf`. Keys are raw `'<ComponentName>.<propertyName>'`
     *                                              (pre-normalisation); values are the wire field name that
     *                                              selects the branch.
     *                                              `attribute-and-phpdoc-driven-serialization` + T-030.
     * @param array<string,string>  $methodRenames  Map of raw operation id → desired PHP method name on the
     *                                              emitted client. This is the documented answer to an operation
     *                                              id with no word boundaries: `searchclient` has no algorithmic
     *                                              path to `searchClient`, and guessing would produce a different
     *                                              wrong answer per schema, so paogen keeps the vendor's spelling
     *                                              and the consumer supplies the readable one. Also feeds the
     *                                              names of any models synthesised for that operation's inline
     *                                              payloads. An entry naming an operation id absent from the
     *                                              document fails the run.
     * @param array<string,string>  $tagRenames     Map of raw OpenAPI tag → desired PHP name for the sub-client
     *                                              emitted from it. Without one, paogen transliterates a
     *                                              non-ASCII tag deterministically, which is legible but
     *                                              rarely what a consumer wants: `Клиенты` becomes `Klienty`
     *                                              where they meant `Customers`. An entry naming a tag no
     *                                              operation carries fails the run.
     * @param array<string,string>  $tagAssignments Map of raw operation id → raw tag, for an operation the
     *                                              document left untagged. Repairs an under-tagged vendor
     *                                              document without editing it: the operation moves off the
     *                                              root client and onto the named tag's sub-client. The tag
     *                                              need not already exist in the document.
     * @param array<string,string>  $tagChoice      Map of raw operation id → raw tag, for an operation carrying
     *                                              several tags. By default it is emitted on every one of its
     *                                              sub-clients; this picks one. A choice naming a tag the
     *                                              operation does not carry fails the run.
     * @param array<string,string>  $xmlElements    Names the XML elements for an operation whose request body the
     *                                              document declared `application/xml`. Keys are the raw operation
     *                                              id for the root element, and `'<operationId>.item'` for the
     *                                              repeated element of a body that is a bare array. OpenAPI
     *                                              supplies a default for neither — a property becomes an element
     *                                              of the same name, but nothing names the document root — so an
     *                                              XML body with no entry here fails the run rather than guessing.
     *                                              A wrong root element is a 400 from the vendor, and asking at
     *                                              generation time is cheaper than finding out at runtime.
     * @param array<string,string>  $inlineModels   Pins the class name paogen synthesises for an operation's
     *                                              inline payload. Keys are `'<operationId>.request'` or
     *                                              `'<operationId>.response'` using the raw operation id from
     *                                              the document; values are the PHP class name. Overrides the
     *                                              derivation from the operation's method name. A key naming an
     *                                              operation id absent from the document, or a role outside the
     *                                              two above, fails the run. When a vendor renames an operation
     *                                              id, moving the pin to the new id keeps the class name the
     *                                              consumer's own callers already reference.
     * @param array<string,string>  $propertyRenames Map of `'<RawComponentName>.<wirePropertyName>'` → desired
     *                                              PHP property name, for a model property whose vendor spelling
     *                                              is not one a consumer wants to read on every access —
     *                                              `result_code`, `client_id`, `goods_data`. $methodRenames and
     *                                              $tagRenames already answer this for operation ids and tags;
     *                                              this is the same answer one level down, on the properties
     *                                              those methods hand back. The wire name still has to survive —
     *                                              hydration and marshalling both key on it — so a rename here
     *                                              only changes the PHP-facing name: the emitted constructor
     *                                              parameter takes the desired name and carries `#[WireName]`
     *                                              pointing at the original, the same split
     *                                              `attribute-and-phpdoc-driven-serialization` already uses for
     *                                              a property that keeps its wire spelling for other reasons.
     *                                              The key is dotted rather than a nested array, matching
     *                                              `$xmlElements` and `$inlineModels`, so a rename is scoped to
     *                                              the one model it belongs to and never touches every `id` in
     *                                              the document at once. There is deliberately no automatic
     *                                              snake_case-to-camelCase conversion: that would be a guess,
     *                                              and it would silently move names between runs whenever the
     *                                              vendor edited a schema. A key naming a component absent from
     *                                              the document, or a property absent from that component,
     *                                              fails the run, matching `$inlineModels` and `$tagChoice`. A
     *                                              rename that collides with another property already in the
     *                                              same model — renamed or not — fails the run naming both.
     * @param array<string,array<string,mixed>> $securitySchemes Declarations for schemes a `security` requirement
     *                                              names and `components.securitySchemes` never declares. Keyed by
     *                                              the requirement name; the value is the `securityScheme` object
     *                                              the document should have carried, spelled exactly as it would be
     *                                              in the schema — `['type' => 'apiKey', 'in' => 'header',
     *                                              'name' => 'api_key']`. The vendored petstore document is the
     *                                              case: it requires `api_key` on two operations and declares only
     *                                              `petstore_auth`, so without an entry here those two operations
     *                                              authenticate with nothing. paogen will not guess the header name
     *                                              — a wrong guess is a 401 the consumer debugs at runtime — so an
     *                                              undeclared requirement aborts the run naming this key. An entry
     *                                              for a scheme the document does declare, or one no requirement
     *                                              asks for, fails the run the same way a stale `$skip` entry does.
     * @param array<string,array{field:string,map:array<string,string>}> $unionTags Layer one for a property-level
     *                                              `oneOf`/`anyOf` whose selecting tag lives on the *enclosing*
     *                                              object rather than inside the value. Keyed by raw
     *                                              `'<ComponentName>.<propertyName>'`; `field` names a property of
     *                                              that component, and `map` sends each wire value of that field to
     *                                              the raw component name of the branch it selects. GitHub's
     *                                              `event.payload` is the case this exists for: sixteen branches
     *                                              chosen by the sibling `event.type`, with one branch
     *                                              (`public-event`) declaring no properties at all, so nothing
     *                                              inside the value could ever select it. Every part is checked
     *                                              against the document — the component, the property, the union,
     *                                              the field, each branch, and each tag value against the field's
     *                                              `enum` where it declares one. A tag refines what paogen would
     *                                              otherwise compute rather than suppressing anything, so unlike
     *                                              $skip and $unionPins it is not stale-checked: an entry that
     *                                              stays true of the document stays valid even once the branches
     *                                              grow a computable discriminating field.
     * @param array<string,array{branch:string,reason:string}> $unionPins Layer three. Where two branches share
     *                                              every discriminating field the run refuses; this narrows the
     *                                              property to one branch instead, typing it as that single class.
     *                                              Keyed the same way; `branch` is the raw component name and
     *                                              `reason` is the written justification $skip entries also carry.
     *                                              This is an opt-out in the sense
     *                                              `skip-is-the-only-opt-out` means: it is the only guidance key
     *                                              whose *absence* changes the exit status, so it is stale-checked
     *                                              exactly as $skip is — a pin on a union the run can now decide
     *                                              fails until it is deleted. It is also reported on every run,
     *                                              because it is worse than a skip rather than milder: a skip
     *                                              leaves nothing to be wrong with, while a pinned property
     *                                              hydrates a discarded branch's payload into the pinned class
     *                                              with no error at all, those branches accepting each other's
     *                                              payloads being why the union was undecidable in the first
     *                                              place. There is deliberately no preference-order form: picking
     *                                              the first of several matches is the silent guess the whole
     *                                              design exists to refuse.
     * @param array<string,string>  $skip           Operation id or raw component name → human reason. A
     *                                              skip-listed item is omitted from the output instead of
     *                                              failing the run. An entry that no longer matches a problem
     *                                              (the item now generates cleanly), or that names an
     *                                              operation id / component absent from the schema, fails the
     *                                              run instead of being ignored. See
     *                                              abort-on-unrepresentable-constructs.
     * @param string                $source         How this profile is named in the header of every file it
     *                                              produces, and in the regenerate command that header prints.
     *                                              {@see ProfileLoader} fills it with the path the run was given,
     *                                              relative to the directory it was invoked from — never absolute,
     *                                              because an absolute path would make one machine's output differ
     *                                              from another's and turn a re-run into a diff. A profile built in
     *                                              code rather than loaded from disk keeps the default, which names
     *                                              the file paogen's own examples and docs use.
     */
    public function __construct(
        public string $schema,
        public string $output,
        public string $namespace,
        public array $discoverIn = [],
        public array $renames = [],
        public ?NameNormaliser $nameNormaliser = null,
        public array $discriminators = [],
        public array $unionTags = [],
        public array $unionPins = [],
        public array $skip = [],
        public array $methodRenames = [],
        public array $tagRenames = [],
        public array $tagAssignments = [],
        public array $tagChoice = [],
        public array $xmlElements = [],
        public array $inlineModels = [],
        public array $propertyRenames = [],
        public array $securitySchemes = [],
        public string $source = 'paogen.php',
    ) {}

    /**
     * Copy this profile with one or two fields replaced.
     *
     * The single hand-enumerated copy of every field lives here, next to the
     * constructor it has to track. It used to live in `GenerateCommand`, one
     * file away, and rotted twice — `$inlineModels`, then the tag maps and
     * `$xmlElements`, each added to the constructor and silently not carried,
     * so a `--output` run quietly discarded the consumer's guidance and
     * reported success. A second copy for `$source` would have been a third
     * chance at the same bug; there is one copy now, and
     * `OutputOverrideCarriesEveryProfileFieldTest` reflects over the
     * constructor to fail when a field skips it.
     */
    public function with(?string $output = null, ?string $source = null): self
    {
        return new self(
            schema: $this->schema,
            output: $output ?? $this->output,
            namespace: $this->namespace,
            discoverIn: $this->discoverIn,
            renames: $this->renames,
            nameNormaliser: $this->nameNormaliser,
            discriminators: $this->discriminators,
            unionTags: $this->unionTags,
            unionPins: $this->unionPins,
            skip: $this->skip,
            methodRenames: $this->methodRenames,
            tagRenames: $this->tagRenames,
            tagAssignments: $this->tagAssignments,
            tagChoice: $this->tagChoice,
            xmlElements: $this->xmlElements,
            inlineModels: $this->inlineModels,
            propertyRenames: $this->propertyRenames,
            securitySchemes: $this->securitySchemes,
            source: $source ?? $this->source,
        );
    }
}
