#import "@local/speconaut:0.1.0": *
#import "../domain/schema.context.typ": *
#import "../domain/guidance.context.typ": *
#import "../domain/generation.context.typ": *
#import "../domain/runtime.context.typ": *

#feature(
  "Model Generator",
  description: [
    Walks #the(Schema)'s `components.schemas` and emits one #a(Model) per
    entry. Property types follow OpenAPI scalar semantics; `$ref` becomes a
    typed reference to #the([target], Model); `#[BindsFormat]` from the user
    side overrides the property type with #the(ValueObject).
  ],
)[

  #rule("Class emission")[
    #scenario(
      "Each named schema component becomes a final readonly class",
      stage: "unstable",
    )[
      #given[#the(Schema) declares a component named #p((name: "Pet"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[a file `Generated/Model/Pet.php` is written under #the(Profile)'s `output`]
      #and_[the emitted class is `final readonly` in #the(Profile)'s `namespace` `\Generated\Model`]
    ]

    #scenario(
      "Property types follow OpenAPI scalars and required-ness",
      stage: "unstable",
    )[
      #given[#a(Model) with required #p((prop: "id: integer")) and optional #p((prop: "name: string"))]
      #when[#the(Model) is emitted]
      #then[#the(Model)'s constructor has a promoted `int $id` parameter]
      #and_[#the(Model)'s constructor has a promoted `?string $name = null` parameter]
    ]

    #scenario(
      "A `$ref` to another component becomes a typed property of that class",
      stage: "unstable",
    )[
      #given[#a(Model) #p((parent: "Order")) has a required property `pet` that #p((ref: "$ref")) #p((target: "#/components/schemas/Pet"))]
      #when[#the(Model) is emitted]
      #then[#the(Model) `Order` has a promoted constructor parameter typed as `Pet`]
    ]

    #scenario(
      "An inline nested object schema becomes a synthesised typed class",
      stage: "unstable",
    )[
      #given[#a(Model) #p((parent: "Pet")) declares an inline property `shipping` with `type: object` and nested properties #p((props: "address: string, zip: string"))]
      #when[#the(Model) is emitted]
      #then[#a(GeneratedFile) `Generated/Model/PetShipping.php` is written]
      #and_[#the(Model) `Pet` has a promoted constructor parameter `PetShipping $shipping`]
      #and_[#the(Model)'s `shipping` property is *not* typed `array<string, mixed>`]
    ]

    #scenario(
      "A schema with enum values becomes a PHP 8.1 backed enum",
      stage: "unstable",
    )[
      #given[#the(Schema) declares a named component `Status` with `type: string` and #p((enum: "[placed, approved, delivered]"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#a(GeneratedFile) `Generated/Enum/Status.php` is written]
      #and_[#the(GeneratedFile) is emitted as `enum Status: string` with one PascalCased case per declared value]
      #and_[#a(Model) that references `#/components/schemas/Status` is typed with the enum, not `string`]
    ]

    #scenario(
      "A `oneOf` of `$ref`-ed components with a `discriminator` becomes a PHP union type",
      stage: "unstable",
    )[
      #given[#the(Schema) declares components `Dog` and `Cat` and #a(Model) `Animal` with a required property `creature` whose schema is `oneOf: [$ref Dog, $ref Cat]` with `discriminator.propertyName: petType`]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#the(Model) `Animal` has a promoted constructor parameter typed `Dog|Cat`]
    ]

    #scenario(
      "A `oneOf` whose branches share every discriminating field aborts the run, naming both",
      stage: "unstable",
    )[
      #given[#the(Schema) declares components `Celsius` and `Fahrenheit` that declare the same single optional property and require nothing, and a component `Reading` with a required property `sample` whose schema is `oneOf: [$ref Celsius, $ref Fahrenheit]` with no `discriminator`]
      #and_[#the(Profile) names no tag on the enclosing object and pins no branch for #p((key: "Reading.sample"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#the(Generator)'s run aborts with #p((error: "UnrepresentableConstructsException")) whose message names `Reading.sample` and both branches]
      #and_[#the(Generator)'s message names what would resolve it: a `discriminator` in #the(Schema), a `unionTags` entry on #the(Profile), or a `unionPins` entry on #the(Profile)]
      #and_[no files are written under #the(Profile)'s `output`]
    ]

    #scenario(
      "A `oneOf` whose branches require disjoint fields becomes a PHP union with a computed selector",
      stage: "unstable",
    )[
      #given[#the(Schema) declares components `Dog` (required `bark`) and `Cat` (required `meow`) and a component `Sighting` with a required property `creature` whose schema is `oneOf: [$ref Dog, $ref Cat]` with no `discriminator`]
      #and_[#the(Profile) names no tag on the enclosing object and pins no branch for #p((key: "Sighting.creature"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#the(Model)'s `creature` parameter is typed `Dog|Cat` — neither `mixed` nor an array]
      #and_[#the(Model)'s `creature` parameter carries `#[BranchSelector(fields: ['bark' => Dog::class, 'meow' => Cat::class])]`]
      #and_[#the(Generator) reports which field it will discriminate on for that union, before anything runs]
    ]

    #scenario(
      "A branch that closes itself and declares nothing is selected by an empty payload",
      stage: "unstable",
    )[
      #given[#the(Schema) declares a component `Vacant` with `additionalProperties: false` and no properties, and a component `Enclosure` with a required property `occupant` whose schema is `oneOf: [$ref Dog, $ref Vacant]` with no `discriminator`]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#the(Model)'s `occupant` parameter carries a `#[BranchSelector]` naming `Vacant` as the branch an empty payload selects]
      #and_[#the(Model)'s `occupant` parameter is typed `Dog|Vacant`]
    ]

    #scenario(
      "A pinned branch types the property as that single class",
      stage: "unstable",
    )[
      #given[#the(Schema) declares a component `Reading` whose required property `sample` is an undecidable `oneOf: [$ref Celsius, $ref Fahrenheit]`]
      #and_[#the(Profile) pins #p((branch: "Celsius")) for `Reading.sample` with a written reason]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#the(Model)'s `sample` parameter is typed `Celsius` and carries no branch-selection attribute]
      #and_[#the(Generator) reports the pin on every run, naming the branches it made unreachable]
    ]

    #scenario(
      "A profile-level `discriminators` override resolves an otherwise-undiscriminated `oneOf`",
      stage: "unstable",
    )[
      #given[#the(Schema) declares components `Dog` and `Cat` and a component `Pet` with a required property `kind` whose schema is `oneOf: [$ref Dog, $ref Cat]` with no `discriminator`]
      #and_[#the(Profile) sets #p((discriminators: "'Pet.kind' => 'petType'"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#a(GeneratedFile) `Generated/Model/Pet.php` is written]
      #and_[#the(Model)'s `kind` constructor parameter carries `#[Discriminator(field: 'petType', ...)]`]
    ]

    #scenario(
      "A `oneOf` with a `discriminator.propertyName` picks the branch by wire value",
      stage: "unstable",
    )[
      #given[#the(Schema) declares components `Dog` and `Cat` and #a(Model) `Pet` with a required property `kind` whose schema is `oneOf: [$ref Dog, $ref Cat]` with `discriminator.propertyName: petType`]
      #when[#the(Hydrator) call `(new Hydrator())->hydrate(Pet::class, $data)` runs against a payload whose `kind.petType` is #p((wire: "'Cat'"))]
      #then[#the(Model)'s `$pet->kind` is an instance of `Cat`, independent of whether the payload's keys structurally match `Dog`]
    ]

    #scenario(
      "An `allOf` that merges two object schemas becomes a single Model with the union of properties",
      stage: "unstable",
    )[
      #given[#the(Schema) declares components `BaseThing` (required `id: integer`) and `ExtraThing` (required `label: string`) and #a(Model) `MergedThing` whose schema is `allOf: [$ref BaseThing, $ref ExtraThing]`]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#a(GeneratedFile) `Generated/Model/MergedThing.php` is written]
      #and_[#the(Model) `MergedThing` has promoted constructor parameters `int $id` and `string $label`]
    ]
  ]

  #rule("Hydration and serialization contract (attribute-and-phpdoc-driven-serialization)")[
    #scenario(
      "A list-of-Model property hydrates each item into the declared class",
      stage: "unstable",
    )[
      #given[#a(Model) `Pet` has a property `tags` whose schema is `type: array, items.$ref: #/components/schemas/Tag`]
      #when[#the(Hydrator) (attribute-and-phpdoc-driven-serialization) runs against a payload whose `tags` is a list of two objects]
      #then[#the(Model)'s `$pet->tags[0]` is an instance of `Tag`]
      #and_[#the(Model)'s `$pet->tags[1]` is an instance of `Tag`]
    ]

    #scenario(
      "A list-of-scalar property hydrates items untouched",
      stage: "unstable",
    )[
      #given[#a(Model) `Pet` has a property `photoUrls` whose schema is `type: array, items.type: string`]
      #when[#the(Hydrator) (attribute-and-phpdoc-driven-serialization) runs against a payload whose `photoUrls` is a list of plain strings]
      #then[each `$pet->photoUrls[$i]` on #the(Model) is the original string — no object wrapping]
    ]

    #scenario(
      "A property with a non-identifier schema key round-trips via #[WireName]",
      stage: "unstable",
    )[
      #given[#a(Model) `Contact` declares a required property whose schema key is `display-name` (kebab-case)]
      #when[#the(Generator) emits `Contact.php` and the runtime `Marshaller` / `Hydrator` (attribute-and-phpdoc-driven-serialization) process a payload containing the wire key `display-name`]
      #then[#the(Model)'s constructor parameter is emitted as `$displayName` (camelCased PHP identifier)]
      #and_[#the(Model)'s property carries `#[WireName('display-name')]`, and the class has no `PROPERTY_MAP` constant]
      #and_[#the(Hydrator)'s `(new Hydrator())->hydrate(Contact::class, ['display-name' => 'Ada'])` populates `$contact->displayName === 'Ada'`]
      #and_[#the(Marshaller)'s `(new Marshaller())->marshal($contact)` emits the key as `display-name`, not `displayName`]
    ]

    #scenario(
      "Generated Models carry no PROPERTY_MAP and do not implement JsonSerializable",
      stage: "unstable",
    )[
      #given[#a(Model) `Order` is emitted by #the(Generator) under attribute-and-phpdoc-driven-serialization]
      #when[#a(GeneratedFile) `Generated/Model/Order.php` is read]
      #then[#the(GeneratedFile) contains no `PROPERTY_MAP` class constant and no `implements JsonSerializable`]
      #and_[#the(Model)'s class is `final readonly` with constructor-promoted properties only]
      #and_[#the(Model)'s wire metadata (when needed) is carried by the small attribute-and-phpdoc-driven-serialization attribute set on each parameter]
    ]

    #scenario(
      "A discriminated `oneOf` hydrates to the branch named by the wire tag via #[Discriminator]",
      stage: "unstable",
    )[
      #given[#a(Model) `Pet` declares a required property `kind` whose schema is `oneOf: [$ref Dog, $ref Cat]` with `discriminator.propertyName: petType`]
      #when[#a(GeneratedFile) `Pet.php` is read and the runtime `Hydrator` (attribute-and-phpdoc-driven-serialization) runs against a payload whose `kind.petType` is #p((wire: "'Cat'"))]
      #then[#the(Model)'s `kind` parameter carries `#[Discriminator(field: 'petType', map: ['Dog' => Dog::class, 'Cat' => Cat::class])]`]
      #and_[#the(Model)'s `$pet->kind` is an instance of `Cat`, independent of structural overlap with `Dog`]
    ]

    #scenario(
      "A payload matching zero branches, or two, raises rather than picking one",
      stage: "unstable",
    )[
      #given[#a(Model) `Sighting` declares a required property `creature` typed `Dog|Cat`, carrying a `#[BranchSelector]` computed from the branches' disjoint required fields]
      #when[#the(Hydrator) runs against a payload whose `creature` carries neither `bark` nor `meow`]
      #then[#the(Client)'s hydration raises, naming the property and the keys the payload carried]
      #and_[#the(Client)'s hydration also raises when `creature` carries both `bark` and `meow`, naming both branches it matched]
      #and_[#the(Client) never resolves either case by taking the first branch — that is what makes computing the selector safe]
    ]

    #scenario(
      "A tag on the enclosing object selects the branch through #[Discriminator(onParent: true)]",
      stage: "unstable",
    )[
      #given[#a(Model) `Habitat` declares a required property `resident` typed `Dog|Cat` and a sibling property `species` enumerating `dog` and `cat`]
      #and_[#the(Profile) maps those two values to the two branches for `Habitat.resident`]
      #when[#the(Hydrator) runs against a payload whose `species` is #p((wire: "'cat'"))]
      #then[#the(Model)'s `resident` parameter carries `#[Discriminator(field: 'species', map: ['cat' => Cat::class, 'dog' => Dog::class], onParent: true)]`]
      #and_[#the(Model)'s `$habitat->resident` is an instance of `Cat`, read from the enclosing payload rather than from the value]
      #and_[#the(Client)'s hydration raises when `species` is absent, and when it carries a value the map does not name]
    ]

    #scenario(
      "Hydration recovers phpdoc types when opcache strips comments (attribute-and-phpdoc-driven-serialization)",
      stage: "unstable",
    )[
      #given[#a(Model) `Pet` declares a property `tags` with phpdoc `@param list<Tag>|null $tags`]
      #and_[#the(Hydrator) runs in a PHP process under `opcache.save_comments=0`, so its `ReflectionMethod::getDocComment()` call returns `false`]
      #when[#the(Hydrator)'s `(new Hydrator())->hydrate(Pet::class, ['tags' => [['id' => 1, 'name' => 'a']]])` runs]
      #then[#the(Hydrator) re-tokenises `Pet.php` via `token_get_all`, recovers the constructor's doc comment, and `$pet->tags[0]` is an instance of `Tag` — not a raw array]
    ]
  ]

  #rule("User bindings replace generated types")[
    #scenario(
      "A property with a format that has a BindsFormat binding uses the user class",
      stage: "unstable",
    )[
      #given[#a(ValueObject) `App\\ValueObject\\Email` is annotated with #p((attr: "#[BindsFormat('email')]"))]
      #and_[#a(Model) has a required property `contact: string` with `format: email`]
      #when[#the(Model) is emitted]
      #then[#the(Model)'s property type in the generated constructor is `\\App\\ValueObject\\Email`, not `string`]
    ]

    #scenario(
      "A BindsFormat scalar value object round-trips through ScalarBinding",
      stage: "unstable",
    )[
      #given[#a(ValueObject) `App\\ValueObject\\Email` is annotated with #p((attr: "#[BindsFormat('email')]")) and implements `ScalarBinding` with a `string $value`]
      #and_[#a(Model) `Contact` declares a required property `email` with `format: email`]
      #when[`json_encode($contact)` runs against #a(Model) `Contact` whose `email` is an `Email('team@example')`]
      #then[#the(Model)'s emitted JSON contains `"email":"team@example"`, not a nested object]
      #and_[`(new Hydrator())->hydrate(Contact::class, ['email' => 'team@example', ...])` produces #a(Model) `Contact` whose `email` is an `Email` instance whose #the(ValueObject.value) equals `'team@example'`]
    ]

    #scenario(
      "A `format: date-time` property is emitted as DateTimeImmutable and round-trips through the wire string",
      stage: "unstable",
    )[
      #given[#a(Model) `Order` declares an optional property `shipDate` with `type: string` and `format: date-time`]
      #and_[no user binding for #a(BindsFormat) `#[BindsFormat('date-time')]` is registered]
      #when[#the(Model) is emitted and the generated `(new Hydrator())->hydrate(Order::class, ...)` runs against a payload whose `shipDate` is #p((wire: "'2026-04-18T12:34:56+00:00'"))]
      #then[#the(Model)'s constructor parameter is typed `?\\DateTimeImmutable`]
      #and_[#the(Model)'s hydrated `Order::$shipDate` is an instance of `\\DateTimeImmutable` whose timestamp matches the parsed RFC-3339 string]
      #and_[#the(Client) call `json_encode($order)` with that `shipDate` emits `"shipDate":"2026-04-18T12:34:56+00:00"` on the wire, not a nested object]
    ]
  ]

  #rule("Component names are normalised through a configurable pipeline (typed-profile-and-colocated-attributes, T-023)")[
    #scenario(
      "A kebab-case component name becomes a PascalCase PHP class under the default pipeline",
      stage: "unstable",
      case: "default-pipeline-runs-without-guidance",
      standards: (link("../standards/guidance-is-data-not-code.standard-260729.typ"),),
    )[
      #given[#the(Schema) declares a component named #p((raw: "security-advisory-ecosystems"))]
      #and_[#the(Profile) does not override `nameNormaliser`]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#a(GeneratedFile) `Generated/Model/SecurityAdvisoryEcosystems.php` is written]
      #and_[every other component of #the(Schema) that `$ref`s `#/components/schemas/security-advisory-ecosystems` resolves to the same PHP class]
    ]

    #scenario(
      "An explicit `renames` entry takes precedence over the auto-sanitiser",
      stage: "unstable",
    )[
      #given[#the(Schema) declares a component named #p((raw: "version-2"))]
      #and_[#the(Profile) sets #p((renames: "'version-2' => 'Legacy_V2'"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#a(GeneratedFile) `Generated/Model/Legacy_V2.php` is written]
      #and_[#a(GeneratedFile) `Generated/Model/Version2.php` is *not* written]
      #and_[every `$ref` to `#/components/schemas/version-2` resolves to #the(Model) `Legacy_V2`]
    ]

    #scenario(
      "A pattern-gated strategy only handles names matching its pattern and falls through otherwise",
      stage: "unstable",
      case: "name-normaliser-shapes-identifiers-only",
      standards: (link("../standards/guidance-is-data-not-code.standard-260729.typ"),),
    )[
      #given[#the(Profile)'s `nameNormaliser` is #p((normaliser: "CompositeNormaliser([LegacyUppercaser(pattern: /^legacy_/), PascalCaseSanitiser])"))]
      #and_[#the(Schema) declares components #p((first: "legacy_thing")) and #p((second: "modern-thing"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#the(Schema)'s `legacy_thing` component is emitted as `LEGACY_THING` by the first strategy]
      #and_[#the(Schema)'s `modern-thing` component falls through to `PascalCaseSanitiser` and is emitted as `ModernThing`]
    ]

    #scenario(
      "A custom pipeline that returns null for every name aborts with a pointed diagnostic",
      stage: "unstable",
    )[
      #given[#the(Profile)'s `nameNormaliser` is an empty `CompositeNormaliser` (no strategies)]
      #and_[#the(Schema) declares any component, e.g. #p((raw: "anything"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#the(Generator)'s run aborts with an error naming `anything` and pointing at the empty normaliser pipeline]
      #and_[no files are written under #the(Profile)'s `output`]
    ]

    #scenario(
      "Two raw component names that normalise to the same PHP class abort the run",
      stage: "unstable",
    )[
      #given[#the(Schema) declares components named #p((first: "foo-bar")) and #p((second: "foo_bar"))]
      #and_[#the(Profile) does not override `nameNormaliser`]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#the(Generator)'s run aborts with an error naming both raw keys and the shared PHP class `FooBar`]
      #and_[no files are written under #the(Profile)'s `output`]
    ]
  ]

  #rule("Top-level components beyond `type: object` (T-026)")[
    #scenario(
      "A scalar component emits a `ScalarBinding` VO that round-trips the raw scalar",
      stage: "unstable",
    )[
      #given[#the(Schema) declares a component #p((raw: "urn")) with #p((type: "string")) (no `enum`, no `properties`)]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#a(GeneratedFile) `Generated/Model/Urn.php` is written whose class is `final readonly class Urn implements ScalarBinding`]
      #and_[#the(Model)'s constructor has a single promoted `public string $value` and the class emits matching `fromScalar()` / `toScalar()` methods]
      #and_[a sibling #a(Model) that `$ref`s `#/components/schemas/urn` uses `\Generated\Model\Urn` as the property type and `(new Marshaller())->marshal($model)` emits the property as a plain string, not a nested object]
    ]

    #scenario(
      "A top-level `oneOf` with inline object branches emits an interface and one Model per branch",
      stage: "unstable",
    )[
      #given[#the(Schema) declares a component #p((raw: "floating_ip_create")) whose schema is `oneOf: [<inline object A with title "Assign to Droplet">, <inline object B with title "Reserve to Region">]`]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#a(GeneratedFile) `Generated/Model/FloatingIpCreate.php` is an empty interface]
      #and_[Both #the(Model) files `Generated/Model/FloatingIpCreateAssignToDroplet.php` and `Generated/Model/FloatingIpCreateReserveToRegion.php` are `final readonly` classes that `implements FloatingIpCreate`]
      #and_[#a(Operation) that references `floating_ip_create` as a request body types a method parameter `FloatingIpCreate $body`]
    ]

    #scenario(
      "A top-level `oneOf` with `$ref` branches marks the branch Models as `implements <Interface>`",
      stage: "unstable",
    )[
      #given[#the(Schema) declares components `LabeledIssueEvent` and `UnlabeledIssueEvent` (both `type: object`) and a component #p((raw: "issue_event_for_issue")) whose schema is `anyOf: [$ref LabeledIssueEvent, $ref UnlabeledIssueEvent]`]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#a(GeneratedFile) `Generated/Model/IssueEventForIssue.php` is an empty interface]
      #and_[Both #the(Model) files `LabeledIssueEvent.php` and `UnlabeledIssueEvent.php` declare `implements IssueEventForIssue` in their class headers]
    ]

    #scenario(
      "A top-level `type: array` component emits a typed wrapper class",
      stage: "unstable",
    )[
      #given[#the(Schema) declares a component #p((raw: "tags_array")) whose schema is `type: array, items.type: string`]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#a(GeneratedFile) `Generated/Model/TagsArray.php` is written whose class is `final readonly class TagsArray`]
      #and_[#the(Model)'s constructor has a single promoted `public array $items` with phpdoc `@param list<string> $items`]
    ]
  ]

  #rule("Payloads the document declared inline become models too (inline-body-and-response-schemas)")[
    #scenario(
      "A document declaring no components still emits a model for every payload",
      stage: "unstable",
    )[
      #given[#the(Schema) declares an empty `components.schemas` and #an(Operation) #p((id: "placeOrder")) whose `application/json` request body and 2xx response are each an inline `type: object` with declared properties]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#a(GeneratedFile) `Generated/Model/PlaceOrderRequestContent.php` and #a(GeneratedFile) `Generated/Model/PlaceOrder200Content.php` are both written]
      #and_[the emitted #the(Client) declares `placeOrder(PlaceOrderRequestContent $body): PlaceOrder200Content`]
      #and_[#the(Operation) is *not* reported as a skip]
    ]

    #scenario(
      "An inline array of inline objects is typed at both ends",
      stage: "unstable",
    )[
      #given[#an(Operation) #p((id: "placeOrdersBulk")) whose request body and 2xx response are each `type: array` whose `items` is an inline `type: object` with declared properties]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#a(GeneratedFile) `Generated/Model/PlaceOrdersBulkRequestContentItem.php` and #a(GeneratedFile) `Generated/Model/PlaceOrdersBulk200ContentItem.php` are written for the item shapes]
      #and_[the emitted #the(Client) types the parameter `list<PlaceOrdersBulkRequestContentItem>` and the return `list<PlaceOrdersBulk200ContentItem>` in phpdoc]
    ]

    #scenario(
      "Nesting below a synthesised payload is reached by the same queue as nesting below a component",
      stage: "unstable",
    )[
      #given[#an(Operation) #p((id: "placeOrder")) whose inline response carries an inline object property `shipping` and an array property `lines` whose items are an inline object]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#a(GeneratedFile) `Generated/Model/PlaceOrder200ContentShipping.php` and #a(GeneratedFile) `Generated/Model/PlaceOrder200ContentLinesItem.php` are written]
      #and_[#the(Model) two properties are typed as those classes rather than `array<string, mixed>`]
    ]

    #scenario(
      "An inline enum inside a payload becomes a backed enum, wherever the payload came from",
      stage: "unstable",
    )[
      #given[#an(Operation) #p((id: "placeOrder")) whose inline request body has a property `channel` with `type: string` and #p((cases: "enum: [web, phone, store]"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#a(GeneratedFile) `Generated/Enum/PlaceOrderRequestContentChannel.php` is a backed enum with those three cases]
      #and_[#a(Model) nested inside a named component resolves an identical inline `enum` the same way, so the reading does not depend on where the property was declared]
    ]

    #scenario(
      "An inline object the document left unconstrained is passed as a map rather than dropping the operation",
      stage: "unstable",
    )[
      #given[#an(Operation) #p((id: "ping")) whose `application/json` request body is `type: object` with no declared properties and no `additionalProperties`]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the emitted #the(Client) declares `ping(array $body): void` with phpdoc `@param array<string, mixed> $body`]
      #and_[#the(Operation) is *not* reported as a skip, because a map is what #the(Schema) said rather than a shape #the(Generator) could not represent]
    ]

    #scenario(
      "The profile pins the class name for a synthesised payload",
      stage: "unstable",
    )[
      #given[#the(Profile) whose `inlineModels` map carries #p((pin: "'PlacedOrder' => 'placeOrder.200'"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[#a(GeneratedFile) `Generated/Model/PlacedOrder.php` is written and no `PlaceOrder200Content.php` is]
      #and_[the pin renames the root alone, so #a(Model) nested under it is emitted as `PlacedOrderShipping`]
    ]

    #scenario(
      "A pin naming a site absent from the document fails the run",
      stage: "unstable",
    )[
      #given[#the(Profile) whose `inlineModels` map carries a value `'noSuchOperation.request'`]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the run fails naming the site and saying it is absent from #the(Schema)]
      #and_[no #a(GeneratedFile) is written, so guidance that has outlived #the(Operation) it named cannot pass unnoticed]
    ]

    #scenario(
      "Two shapes deriving one class name fail the run rather than overwriting a file",
      stage: "unstable",
    )[
      #given[#the(Schema) declares a component named `PlaceOrder200Content` and #an(Operation) #p((id: "placeOrder")) whose inline response derives that same name]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the run fails naming #the(Model) and both origins — the component name, and the JSON pointer of the inline response]
      #and_[the message names #the(Profile) key that resolves it, so the reader is not left to guess which knob applies]
    ]
  ]

  #rule("Re-running the generator is byte-stable")[
    #scenario(
      "Running the generator twice with the same inputs produces identical files",
      stage: "unstable",
    )[
      #given[#the(Generator) has run once and produced #the(GeneratedFile) tree]
      #when[#the(Generator) runs again with the same #the(Schema) and #the(Profile)]
      #then[every file under #the(Profile)'s `output` is byte-for-byte identical to the previous run]
    ]

    #scenario(
      "A component removed from the schema is pruned from Generated/ on the next run",
      stage: "unstable",
    )[
      #given[#the(Generator) has produced `Generated/Model/Pet.php` from a prior schema that declared a `Pet` component]
      #when[#the(Generator) runs again with a schema from which the `Pet` component has been removed]
      #then[#a(GeneratedFile) `Generated/Model/Pet.php` is no longer on disk]
      #and_[files placed alongside `Generated/` under #the(Profile)'s `output` directory remain untouched]
    ]
  ]

  #rule("Every emitted file declares itself generated")[
    #scenario(
      "An emitted file opens with a header naming the profile and the command that reproduces it",
      stage: "unstable",
    )[
      #given[#the(Profile) was loaded from `tests/fixtures/profiles/petstore.php`]
      #when[#the(Generator) runs against #the(Profile)]
      #then[every #the(GeneratedFile) written opens with a comment saying it was generated by poagen and must not be edited by hand]
      #and_[that comment names #the(Profile) as `tests/fixtures/profiles/petstore.php`]
      #and_[that comment prints the command that reproduces #the(GeneratedFile): `poagen generate tests/fixtures/profiles/petstore.php`]
    ]

    #scenario(
      "The header carries nothing that moves between runs",
      stage: "unstable",
    )[
      #given[#the(Generator) has run once and produced #the(GeneratedFile) tree]
      #when[#the(Generator) runs again over #the([same], Schema) and #the([same], Profile)]
      #then[every #the(GeneratedFile)'s header is byte-identical to the previous run's]
      #and_[nothing in #a(GeneratedFile)'s header is a timestamp, a version, or an absolute path]
    ]

    #scenario(
      "Regenerating over an existing tree replaces it rather than failing on it",
      stage: "unstable",
    )[
      #given[#the(Generator) has already written #the(GeneratedFile) tree into #the(Profile)'s `output`]
      #when[#the(Generator) runs a second time into #the([same], Profile)'s `output`]
      #then[the second run overwrites every #the(GeneratedFile) and reports no error]
      #and_[#the(GeneratedFile) tree on disk is byte-identical to the tree the first run left]
    ]
  ]
]
