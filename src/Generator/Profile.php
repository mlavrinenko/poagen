<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

use Mlavrinenko\Paogen\Generator\Naming\NameNormaliser;

/**
 * User-supplied generation guidance. See ADR-001 / ADR-003.
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
     *                                              merged in automatically. See ADR-003 (T-023).
     * @param array<string,string>  $discriminators Override map for undiscriminated property-level
     *                                              `oneOf`/`anyOf`. Keys are raw `'<ComponentName>.<propertyName>'`
     *                                              (pre-normalisation); values are the wire field name that
     *                                              selects the branch. ADR-010 + T-030.
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
        public array $skip = [],
        public array $methodRenames = [],
        public array $tagRenames = [],
        public array $tagAssignments = [],
        public array $tagChoice = [],
        public array $xmlElements = [],
        public array $inlineModels = [],
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
            skip: $this->skip,
            methodRenames: $this->methodRenames,
            tagRenames: $this->tagRenames,
            tagAssignments: $this->tagAssignments,
            tagChoice: $this->tagChoice,
            xmlElements: $this->xmlElements,
            inlineModels: $this->inlineModels,
            source: $source ?? $this->source,
        );
    }
}
