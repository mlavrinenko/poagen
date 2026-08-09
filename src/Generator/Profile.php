<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator;

use Poagen\Generator\Generator\Emit\WebhookSkipKey;
use Poagen\Runtime\Codec;
use Poagen\Runtime\ScalarBinding;

/**
 * User-supplied generation guidance. See `profile-driven-generation` /
 * `typed-profile-and-colocated-attributes`.
 *
 * Pure value object: parsed by the generator, never executed. The per-field
 * "why" behind each entry below stays intentionally short — the run itself
 * explains a rejected entry in full when guidance is wrong, via the
 * validator each field cites.
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
     * @param Naming\NameNormaliser|null $nameNormaliser Custom normalisation pipeline. When null, poagen
     *                                              composes RenamesNormaliser($renames) + PascalCaseSanitiser;
     *                                              when set, poagen uses it verbatim — $renames is *not* merged
     *                                              in automatically. See `typed-profile-and-colocated-attributes`
     *                                              (T-023).
     * @param array<string,string>  $discriminators Override map for undiscriminated property-level
     *                                              `oneOf`/`anyOf`. Keys are raw `'<ComponentName>.<propertyName>'`
     *                                              (pre-normalisation); values are the wire field name that
     *                                              selects the branch. `attribute-and-phpdoc-driven-serialization`
     *                                              + T-030.
     * @param array<string,string>  $methodRenames  Raw operation id → desired PHP method name on the emitted
     *                                              client. An id with no word boundary (`searchclient`) has no
     *                                              algorithmic path to a readable name, so poagen keeps the
     *                                              vendor spelling and the consumer supplies this one — also
     *                                              feeding the names of any models synthesised for that
     *                                              operation's inline payloads. An entry naming an operation id
     *                                              absent from the document fails the run.
     * @param array<string,string>  $tagRenames     Raw OpenAPI tag → desired PHP name for the sub-client
     *                                              emitted from it. Without one, poagen transliterates a
     *                                              non-ASCII tag deterministically — legible, rarely what a
     *                                              consumer wants: `Клиенты` becomes `Klienty`, not `Customers`.
     *                                              An entry naming a tag no operation carries fails the run.
     * @param array<string,string>  $tagAssignments Raw operation id → raw tag, for an operation the document
     *                                              left untagged. Moves the operation off the root client and
     *                                              onto the named tag's sub-client without editing the document;
     *                                              the tag need not already exist there.
     * @param array<string,string>  $tagChoice      Raw operation id → raw tag, for an operation carrying
     *                                              several tags — by default emitted on every one of its
     *                                              sub-clients, this picks one. A choice naming a tag the
     *                                              operation does not carry fails the run.
     * @param array<string,string>  $xmlElements    Names the XML elements for an operation whose request body
     *                                              the document declared `application/xml`. OpenAPI supplies a
     *                                              default for neither the root nor a bare-array body, so an XML
     *                                              body with no entry here fails the run rather than guessing —
     *                                              a wrong root element is a 400 from the vendor. Three key
     *                                              forms: the raw operation id names the document root;
     *                                              `'<operationId>.item'` names the repeated element of a body
     *                                              that is a bare array; `'<operationId>.item.<propertyName>'`
     *                                              names the repeated child of a *nested* array property the
     *                                              vendor wants wrapped in one element, instead of OpenAPI's
     *                                              unwrapped default. All three are validated against the
     *                                              document the same way, and only the third is wired into the
     *                                              generated call — `Endpoint::xmlList()` takes it directly, so
     *                                              a consumer writes nothing beyond this entry
     *                                              (thread-the-validated-nested-container-map-into-the-generated-client).
     * @param array<string, string|list<string>> $inlineModels Names — and optionally merges — the class(es)
     *                                              poagen synthesises for an operation's inline payloads. Keys
     *                                              are the PHP class name; values are one site or several, each
     *                                              `'<operationId>.request'` or `'<operationId>.<status>'`
     *                                              (name-inline-schemas-by-operation-and-status). Several sites
     *                                              merge into one class only when listed together here —
     *                                              nothing merges without an entry. A site absent from the
     *                                              document fails the run, as does a merge whose sites do not
     *                                              all emit the identical shape, naming the two sites that
     *                                              differ and the property they differ on.
     * @param array<string, list<string>> $responseMaps Names the operations whose response map is ONE shared declaration, keyed by the PHP method poagen emits for it on `Generated\ResponseMaps` — the emitter then writes that map once and every named operation calls it, instead of each spelling out its own `StatusResponseMap` literal. Sharing is stated, never inferred: two operations that happen to declare identical responses stay separate unless a group names them, because structural identity is not identity of meaning (the 2026-08-02 ruling on inline models, one layer up). A malformed group fails before the document is read {@see ResponseMapGroups}; a group naming an operation the document does not carry, an operation this run refuses, or operations whose maps are not in fact identical fails naming the entry and the two members that differ {@see Emit\SharedResponseMapPlan}. Declaring none costs nothing — no file is emitted and every other byte is unchanged.
     * @param array<string,string>  $propertyRenames Map of `'<RawComponentName>.<wirePropertyName>'` → desired
     *                                              PHP property name, for a vendor spelling not worth reading on
     *                                              every access (`result_code`, `client_id`, `goods_data`) — the
     *                                              same answer $methodRenames and $tagRenames already give one
     *                                              level up, applied to properties. The wire name still has to
     *                                              survive hydration and marshalling, so a rename here changes
     *                                              only the PHP-facing name: the emitted parameter carries
     *                                              `#[WireName]` pointing at the original
     *                                              (attribute-and-phpdoc-driven-serialization). There is
     *                                              deliberately no automatic snake_case-to-camelCase conversion
     *                                              — that would be a guess, silently moving names between runs
     *                                              whenever the vendor edited a schema. A key naming a component
     *                                              or property absent from the document, or a rename colliding
     *                                              with another property already in the same model, fails the
     *                                              run naming both.
     * @param array<string,string>  $phpDocTypes    Forces a model property's PHPDoc type, keyed like $propertyRenames — the override channel for a narrowing OpenAPI cannot spell (chiefly `numeric-string`), winning over the constraint-derived narrowing {@see Emit\PhpDocTypeRefiner} computes; a stale key fails the run {@see PhpDocTypeValidator} (refined-phpdoc-types), and so does a value the property cannot carry — a base type the native one contradicts, a structural or class-typed property, a nullability the schema already decides {@see Emit\PhpDocTypeCompatibility}.
     * @param array<string,string>  $formats        Binds a value object or a codec to every property
     *                                              carrying one `format`, document-wide — the same
     *                                              reach `#[BindsFormat]` has, said in the profile
     *                                              instead of on a class the consumer had to write
     *                                              first. That distinction is the whole point for a
     *                                              format poagen already ships a binding for: `'uuid' =>
     *                                              Runtime\Format\RamseyUuidCodec::class` is one line
     *                                              against a value object per project, and swapping
     *                                              libraries is editing that line. Values are a
     *                                              class-string implementing {@see ScalarBinding} — the
     *                                              property is typed as the binding itself — or
     *                                              {@see Codec} — the property is typed
     *                                              as the codec's own target type instead, for a
     *                                              foreign type poagen cannot make implement
     *                                              `ScalarBinding` (`codec-bindings-for-foreign-value-types`);
     *                                              unlike $propertyFormats, whose key cannot be judged
     *                                              until the run has named every model, a key here is a
     *                                              bare format string, so {@see FormatBindingValidator}
     *                                              checks both halves before the document is read and
     *                                              fails naming the format and the class. Loses to a
     *                                              $propertyFormats entry covering the same property,
     *                                              and beats a discovered `#[BindsFormat]` on the same
     *                                              format: explicit guidance over discovery.
     * @param array<string,string>  $propertyFormats Binds a value object or a codec to one property of
     *                                              one model — the per-property answer `#[BindsFormat]`
     *                                              cannot give, because that attribute keys on the
     *                                              format string alone and applies document-wide: on
     *                                              kilbil, `double` covers price, quantity and several
     *                                              percentages, so a `Money` bound to it would type
     *                                              every one of those as money (`bind-a-format-per-property`).
     *                                              Values are a class-string, unverified until the run
     *                                              checks it — same discipline as every other guidance
     *                                              field here, none of which trusts the profile author
     *                                              over the document. Keyed
     *                                              `'<ModelClassName>.<wirePropertyName>'` — the class
     *                                              name poagen assigns the model, not the raw schema key
     *                                              $propertyRenames and $phpDocTypes key on. That
     *                                              departure is deliberate, not stylistic: a document
     *                                              with no named components — kilbil declares none — has
     *                                              no raw schema key for their convention to reuse, while
     *                                              the generated class name is the one identifier every
     *                                              model carries, named or synthesised, and
     *                                              {@see Emit\ModelNameLedger} already guarantees it is
     *                                              unique across the whole tree. The bound class need not
     *                                              carry `#[BindsFormat]` or live under $discoverIn —
     *                                              unlike a discovered binding, this entry
     *                                              takes effect on its own. A stale key naming a
     *                                              property absent from a model this run does emit
     *                                              fails naming both {@see Emit\ModelEmitter} and
     *                                              {@see Emit\PropertyFormatKeys}, named or synthesised
     *                                              alike; a key naming a model this run never emits at
     *                                              all fails the same way, checked once the whole plan
     *                                              has run against every name {@see Emit\ModelNameLedger}
     *                                              claimed {@see PropertyFormatValidator}
     *                                              (queue-drained-models-swallow-emission-failures records
     *                                              why a per-model check alone could not cover this case).
     * @param array<string,array<string,mixed>> $securitySchemes Declarations for schemes a `security` requirement
     *                                              names and `components.securitySchemes` never declares. Keyed
     *                                              by the requirement name; the value is the `securityScheme`
     *                                              object the document should have carried, spelled the same
     *                                              way — e.g. `['type' => 'apiKey', 'in' => 'header', 'name' =>
     *                                              'api_key']`. poagen will not guess the header name — a wrong
     *                                              guess is a 401 debugged at runtime — so an undeclared
     *                                              requirement aborts the run naming this key. An entry for a
     *                                              scheme the document does declare, or one no requirement asks
     *                                              for, fails the run the same way a stale `$skip` entry does.
     * @param array<string,array{field:string,map:array<string,string>}> $unionTags Layer one for a
     *                                              property-level `oneOf`/`anyOf` whose selecting tag lives on
     *                                              the *enclosing* object rather than inside the value. Keyed by
     *                                              raw `'<ComponentName>.<propertyName>'`; `field` names a
     *                                              sibling property of that component, and `map` sends each of
     *                                              its wire values to the raw component name of the branch it
     *                                              selects. Every part is checked against the document — the
     *                                              component, the property, the union, the field, each branch,
     *                                              and each tag value against the field's own `enum` where it
     *                                              declares one. A tag refines what poagen would otherwise
     *                                              compute rather than suppressing anything, so unlike $skip and
     *                                              $unionPins it is not stale-checked.
     * @param array<string,array{branch:string,reason:string}> $unionPins Layer three. Where two branches share
     *                                              every discriminating field the run refuses; this narrows the
     *                                              property to one branch instead, typing it as that single
     *                                              class. Keyed the same way; `branch` is the raw component name
     *                                              and `reason` the written justification $skip entries also
     *                                              carry. Stale-checked exactly as $skip is — a pin on a union
     *                                              the run can now decide fails until deleted — and reported on
     *                                              every run besides, because a pinned property hydrates a
     *                                              discarded branch's payload into the pinned class with no
     *                                              error at all. There is deliberately no preference-order form:
     *                                              picking the first of several matches is the silent guess the
     *                                              whole design exists to refuse.
     * @param array<string,string>  $skip           Operation id, raw component name, or webhook key → human
     *                                              reason. A skip-listed item is omitted; a stale entry, or one
     *                                              naming an id/component/webhook absent from the schema, fails
     *                                              the run instead (abort-on-unrepresentable-constructs). A
     *                                              webhook is named `'<webhookName>.webhook'`
     *                                              ({@see WebhookSkipKey}), suffixed so it cannot collide with a
     *                                              bare id or component. The default stays a refusal; a
     *                                              partly-skipped set still refuses naming the rest
     *                                              (webhooks-refuse-with-no-opt-out).
     * @param string                $source         How this profile is named in the header of every file it
     *                                              produces, and in the regenerate command that header prints.
     *                                              {@see ProfileLoader} fills it with the path the run was
     *                                              given, relative to the invoking directory — never absolute,
     *                                              so one machine's output cannot differ from another's. A
     *                                              profile built in code rather than loaded from disk keeps the
     *                                              default, which names the file poagen's own examples and docs
     *                                              use.
     */
    public function __construct(
        public string $schema,
        public string $output,
        public string $namespace,
        public array $discoverIn = [],
        public array $renames = [],
        public ?Naming\NameNormaliser $nameNormaliser = null,
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
        public array $responseMaps = [],
        public array $propertyRenames = [],
        public array $phpDocTypes = [],
        public array $formats = [],
        public array $propertyFormats = [],
        public array $securitySchemes = [],
        public string $source = 'poagen.php',
    ) {}

    /**
     * Copy this profile with one or two fields replaced. The single
     * hand-enumerated copy of every field lives in {@see ProfileOverride},
     * next to the constructor it has to track — see that class for why
     * there is only ever one copy.
     */
    public function with(?string $output = null, ?string $source = null): self
    {
        return ProfileOverride::apply($this, $output, $source);
    }
}
