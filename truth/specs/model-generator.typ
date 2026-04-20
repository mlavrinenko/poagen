// Feature: Model Generator
// Emit a `final readonly` PHP class for every named schema component, with
// PHPStan-max-clean property types. No operations, no client — those are
// later features.

#import "@local/speconaut:0.1.0": *
#import "../domain.typ": *

#feature(
  "Model Generator",
  traces: (
    "src/Generator/Emit/ModelEmitter.php",
    "src/Generator/Emit/TypeResolver.php",
    "src/Runtime/Marshal/Marshaller.php",
    "src/Runtime/Marshal/Hydrator.php",
    "src/Runtime/Marshal/DescriptorParser.php",
  ),
  description: [
    Walks #the(Schema)'s `components.schemas` and emits one #a(Model) per
    entry. Property types follow OpenAPI scalar semantics; `$ref` becomes a
    typed reference to the target #a(Model); `#[BindsFormat]` from the user
    side overrides the property type with #the(ValueObject).
  ],
)[

  #rule("Class emission")[
    #scenario(
      "Each named schema component becomes a final readonly class",
      stage: unstable,
      traces: ("src/Generator/Generator.php",),
    )[
      #given[#the(Schema) declares a component named #p((name: "Pet"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[a file `Generated/Model/Pet.php` is written under #the(Profile)'s `output`]
      #and_[the emitted class is `final readonly` in #the(Profile)'s `namespace` `\Generated\Model`]
    ]

    #scenario(
      "Property types follow OpenAPI scalars and required-ness",
      stage: unstable,
    )[
      #given[#a(Model) with required #p((prop: "id: integer")) and optional #p((prop: "name: string"))]
      #when[the model is emitted]
      #then[the constructor has a promoted `int $id` parameter]
      #and_[the constructor has a promoted `?string $name = null` parameter]
    ]

    #scenario(
      "A `$ref` to another component becomes a typed property of that class",
      stage: unstable,
    )[
      #given[#a(Model) #p((parent: "Order")) has a required property `pet` that #p((ref: "$ref")) #p((target: "#/components/schemas/Pet"))]
      #when[the model is emitted]
      #then[`Order` has a promoted constructor parameter typed as `Pet`]
    ]

    #scenario(
      "An inline nested object schema becomes a synthesised typed class",
      stage: unstable,
      traces: (
        "src/Generator/Emit/InlineObjectResolver.php",
        "src/Generator/Emit/ModelEmission.php",
        "src/Generator/Emit/SynthesisedModel.php",
        "src/Generator/Generator.php",
      ),
    )[
      #given[#a(Model) #p((parent: "Pet")) declares an inline property `shipping` with `type: object` and nested properties #p((props: "address: string, zip: string"))]
      #when[the model is emitted]
      #then[a class `Generated/Model/PetShipping.php` is written]
      #and_[`Pet` has a promoted constructor parameter `PetShipping $shipping`]
      #and_[the property is *not* typed `array<string, mixed>`]
    ]

    #scenario(
      "A schema with enum values becomes a PHP 8.1 backed enum",
      stage: unstable,
      traces: (
        "src/Generator/Enum/EnumCatalog.php",
        "src/Generator/Enum/EnumSpec.php",
        "src/Generator/Emit/EnumEmitter.php",
        "src/Generator/Generator.php",
      ),
    )[
      #given[#the(Schema) declares a named component `Status` with `type: string` and #p((enum: "[placed, approved, delivered]"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[a file `Generated/Enum/Status.php` is written]
      #and_[the emitted enum is `enum Status: string` with one PascalCased case per declared value]
      #and_[#a(Model) that references `#/components/schemas/Status` is typed with the enum, not `string`]
    ]

    #scenario(
      "A `oneOf` of `$ref`-ed components becomes a PHP union type",
      stage: unstable,
      traces: (
        "src/Generator/Emit/CompositionResolver.php",
        "src/Generator/Emit/ClientEmitter.php",
      ),
    )[
      #given[#the(Schema) declares components `Dog` and `Cat` and #a(Model) `Animal` with a required property `creature` whose schema is `oneOf: [$ref Dog, $ref Cat]` with no `discriminator`]
      #when[the model is emitted and `ApiClient::hydrate(Animal::class, $data)` runs against a payload whose `creature` structurally matches the `Dog` branch]
      #then[`Animal` has a promoted constructor parameter typed `Dog|Cat`]
      #and_[`$animal->creature` is an instance of `Dog`, not `Cat`]
    ]

    #scenario(
      "A `oneOf` with a `discriminator.propertyName` picks the branch by wire value",
      stage: unstable,
      traces: (
        "src/Generator/Emit/CompositionResolver.php",
        "src/Generator/Emit/ClientEmitter.php",
      ),
    )[
      #given[#the(Schema) declares components `Dog` and `Cat` and #a(Model) `Pet` with a required property `kind` whose schema is `oneOf: [$ref Dog, $ref Cat]` with `discriminator.propertyName: petType`]
      #when[`ApiClient::hydrate(Pet::class, $data)` runs against a payload whose `kind.petType` is #p((wire: "'Cat'"))]
      #then[`$pet->kind` is an instance of `Cat`, independent of whether the payload's keys structurally match `Dog`]
    ]

    #scenario(
      "An `allOf` that merges two object schemas becomes a single Model with the union of properties",
      stage: unstable,
      traces: (
        "src/Generator/Emit/CompositionResolver.php",
        "src/Generator/Generator.php",
      ),
    )[
      #given[#the(Schema) declares components `BaseThing` (required `id: integer`) and `ExtraThing` (required `label: string`) and #a(Model) `MergedThing` whose schema is `allOf: [$ref BaseThing, $ref ExtraThing]`]
      #when[#the(Generator) runs against #the(Profile)]
      #then[a file `Generated/Model/MergedThing.php` is written]
      #and_[`MergedThing` has promoted constructor parameters `int $id` and `string $label`]
    ]
  ]

  #rule("Hydration and serialization contract (ADR-010)")[
    #scenario(
      "A list-of-Model property hydrates each item into the declared class",
      stage: unstable,
      traces: (
        "src/Runtime/Marshal/PropertyDescriptor.php",
        "src/Runtime/Marshal/PropertyType.php",
      ),
    )[
      #given[#a(Model) `Pet` has a property `tags` whose schema is `type: array, items.$ref: #/components/schemas/Tag`]
      #when[the runtime `Hydrator` (ADR-010) runs against a payload whose `tags` is a list of two objects]
      #then[`$pet->tags[0]` is an instance of `Tag`]
      #and_[`$pet->tags[1]` is an instance of `Tag`]
    ]

    #scenario(
      "A list-of-scalar property hydrates items untouched",
      stage: unstable,
    )[
      #given[#a(Model) `Pet` has a property `photoUrls` whose schema is `type: array, items.type: string`]
      #when[the runtime `Hydrator` (ADR-010) runs against a payload whose `photoUrls` is a list of plain strings]
      #then[each `$pet->photoUrls[$i]` is the original string — no object wrapping]
    ]

    #scenario(
      "A property with a non-identifier schema key round-trips via #[WireName]",
      stage: unstable,
      traces: ("src/Runtime/Attribute/WireName.php",),
    )[
      #given[#a(Model) `Contact` declares a required property whose schema key is `display-name` (kebab-case)]
      #when[the generator emits `Contact.php` and the runtime `Marshaller` / `Hydrator` (ADR-010) process a payload containing the wire key `display-name`]
      #then[the constructor parameter is emitted as `$displayName` (camelCased PHP identifier)]
      #and_[the property carries `#[WireName('display-name')]`, and the class has no `PROPERTY_MAP` constant]
      #and_[`(new Hydrator())->hydrate(Contact::class, ['display-name' => 'Ada'])` populates `$contact->displayName === 'Ada'`]
      #and_[`(new Marshaller())->marshal($contact)` emits the key as `display-name`, not `displayName`]
    ]

    #scenario(
      "Generated Models carry no PROPERTY_MAP and do not implement JsonSerializable",
      stage: unstable,
      traces: (
        "src/Runtime/Attribute/Format.php",
        "src/Runtime/Attribute/Schema.php",
        "src/Runtime/Attribute/AdditionalProperties.php",
        "src/Runtime/Attribute/Deprecated.php",
      ),
    )[
      #given[#a(Model) `Order` is emitted by #the(Generator) under ADR-010]
      #when[`Generated/Model/Order.php` is read]
      #then[the file contains no `PROPERTY_MAP` class constant and no `implements JsonSerializable`]
      #and_[the class is `final readonly` with constructor-promoted properties only]
      #and_[wire metadata (when needed) is carried by the small ADR-010 attribute set on each parameter]
    ]

    #scenario(
      "A discriminated `oneOf` hydrates to the branch named by the wire tag via #[Discriminator]",
      stage: unstable,
      traces: ("src/Runtime/Attribute/Discriminator.php",),
    )[
      #given[#a(Model) `Pet` declares a required property `kind` whose schema is `oneOf: [$ref Dog, $ref Cat]` with `discriminator.propertyName: petType`]
      #when[the generated `Pet.php` is read and the runtime `Hydrator` (ADR-010) runs against a payload whose `kind.petType` is #p((wire: "'Cat'"))]
      #then[the `kind` parameter carries `#[Discriminator(field: 'petType', map: ['Dog' => Dog::class, 'Cat' => Cat::class])]`]
      #and_[`$pet->kind` is an instance of `Cat`, independent of structural overlap with `Dog`]
    ]
  ]

  #rule("User bindings replace generated types")[
    #scenario(
      "A property with a format that has a BindsFormat binding uses the user class",
      stage: unstable,
      traces: ("src/Generator/AttributeScanner.php",),
    )[
      #given[#a(ValueObject) `App\\ValueObject\\Email` is annotated with #p((attr: "#[BindsFormat('email')]"))]
      #and_[#a(Model) has a required property `contact: string` with `format: email`]
      #when[the model is emitted]
      #then[the property type in the generated constructor is `\\App\\ValueObject\\Email`, not `string`]
    ]

    #scenario(
      "A BindsFormat scalar value object round-trips through ScalarBinding",
      stage: unstable,
      traces: (
        "src/Runtime/ScalarBinding.php",
        "src/Generator/Emit/ClientEmitter.php",
      ),
    )[
      #given[#a(ValueObject) `App\\ValueObject\\Email` is annotated with #p((attr: "#[BindsFormat('email')]")) and implements `ScalarBinding` with a `string $value`]
      #and_[#a(Model) `Contact` declares a required property `email` with `format: email`]
      #when[`json_encode($contact)` runs against a `Contact` whose `email` is an `Email('team@example')`]
      #then[the emitted JSON contains `"email":"team@example"`, not a nested object]
      #and_[`ApiClient::hydrate(Contact::class, ['email' => 'team@example', ...])` produces a `Contact` whose `email` is an `Email` instance with `$value === 'team@example'`]
    ]

    #scenario(
      "A `format: date-time` property is emitted as DateTimeImmutable and round-trips through the wire string",
      stage: unstable,
      traces: (
        "src/Generator/Bindings.php",
        "src/Generator/ScalarFormat.php",
        "src/Generator/Emit/ClientEmitter.php",
      ),
    )[
      #given[#a(Model) `Order` declares an optional property `shipDate` with `type: string` and `format: date-time`]
      #and_[no user `#[BindsFormat('date-time')]` binding is registered]
      #when[the model is emitted and the generated `ApiClient::hydrate(Order::class, ...)` runs against a payload whose `shipDate` is #p((wire: "'2026-04-18T12:34:56+00:00'"))]
      #then[the constructor parameter is typed `?\\DateTimeImmutable`]
      #and_[the hydrated `Order::$shipDate` is an instance of `\\DateTimeImmutable` whose timestamp matches the parsed RFC-3339 string]
      #and_[`json_encode($order)` with that `shipDate` emits `"shipDate":"2026-04-18T12:34:56+00:00"` on the wire, not a nested object]
    ]
  ]

  #rule("Component names are normalised through a configurable pipeline (ADR-003, T-023)")[
    #scenario(
      "A kebab-case component name becomes a PascalCase PHP class under the default pipeline",
      stage: unstable,
      traces: (
        "src/Generator/Naming/PascalCaseSanitiser.php",
        "src/Generator/Naming/CompositeNormaliser.php",
        "src/Generator/Naming/NameRegistry.php",
        "src/Generator/Naming/NormaliserFactory.php",
        "src/Generator/Naming/NormalisationContext.php",
        "src/Generator/Naming/SymbolKind.php",
        "src/Generator/Emit/ComponentName.php",
        "src/Generator/ModelPlanner.php",
        "src/Generator/Generator.php",
      ),
    )[
      #given[#the(Schema) declares a component named #p((raw: "security-advisory-ecosystems"))]
      #and_[#the(Profile) does not override `nameNormaliser`]
      #when[#the(Generator) runs against #the(Profile)]
      #then[a file `Generated/Model/SecurityAdvisoryEcosystems.php` is written]
      #and_[every other component that `$ref`s `#/components/schemas/security-advisory-ecosystems` resolves to the same PHP class]
    ]

    #scenario(
      "An explicit `renames` entry takes precedence over the auto-sanitiser",
      stage: unstable,
      traces: (
        "src/Generator/Naming/RenamesNormaliser.php",
        "src/Generator/Naming/CompositeNormaliser.php",
        "src/Generator/Emit/ComponentName.php",
      ),
    )[
      #given[#the(Schema) declares a component named #p((raw: "version-2"))]
      #and_[#the(Profile) sets #p((renames: "'version-2' => 'Legacy_V2'"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[a file `Generated/Model/Legacy_V2.php` is written]
      #and_[the file `Generated/Model/Version2.php` is *not* written]
      #and_[every `$ref` to `#/components/schemas/version-2` resolves to `Legacy_V2`]
    ]

    #scenario(
      "A pattern-gated strategy only handles names matching its pattern and falls through otherwise",
      stage: unstable,
      traces: (
        "src/Generator/Naming/NameNormaliser.php",
        "src/Generator/Naming/CompositeNormaliser.php",
        "src/Generator/Emit/ComponentName.php",
      ),
    )[
      #given[#the(Profile)'s `nameNormaliser` is #p((normaliser: "CompositeNormaliser([LegacyUppercaser(pattern: /^legacy_/), PascalCaseSanitiser])"))]
      #and_[#the(Schema) declares components #p((first: "legacy_thing")) and #p((second: "modern-thing"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[`legacy_thing` is emitted as `LEGACY_THING` by the first strategy]
      #and_[`modern-thing` falls through to `PascalCaseSanitiser` and is emitted as `ModernThing`]
    ]

    #scenario(
      "A custom pipeline that returns null for every name aborts with a pointed diagnostic",
      stage: unstable,
      traces: (
        "src/Generator/Naming/CompositeNormaliser.php",
        "src/Exception/NameNormalisationException.php",
        "src/Generator/Emit/ComponentName.php",
      ),
    )[
      #given[#the(Profile)'s `nameNormaliser` is an empty `CompositeNormaliser` (no strategies)]
      #and_[#the(Schema) declares any component, e.g. #p((raw: "anything"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the run aborts with an error naming `anything` and pointing at the empty normaliser pipeline]
      #and_[no files are written under #the(Profile)'s `output`]
    ]

    #scenario(
      "Two raw component names that normalise to the same PHP class abort the run",
      stage: unstable,
      traces: (
        "src/Generator/Naming/NameRegistry.php",
        "src/Generator/Emit/ComponentName.php",
      ),
    )[
      #given[#the(Schema) declares components named #p((first: "foo-bar")) and #p((second: "foo_bar"))]
      #and_[#the(Profile) does not override `nameNormaliser`]
      #when[#the(Generator) runs against #the(Profile)]
      #then[the run aborts with an error naming both raw keys and the shared PHP class `FooBar`]
      #and_[no files are written under #the(Profile)'s `output`]
    ]
  ]

  #rule("Re-running the generator is byte-stable")[
    #scenario(
      "Running the generator twice with the same inputs produces identical files",
      stage: unstable,
      traces: (
        "src/Generator/Generator.php",
        "src/Generator/GenerationPlan.php",
        "src/Generator/PlanApplier.php",
      ),
    )[
      #given[#the(Generator) has run once and produced #the(GeneratedFile) tree]
      #when[#the(Generator) runs again with the same #the(Schema) and #the(Profile)]
      #then[every file under #the(Profile)'s `output` is byte-for-byte identical to the previous run]
    ]

    #scenario(
      "A component removed from the schema is pruned from Generated/ on the next run",
      stage: unstable,
      traces: (
        "src/Generator/Generator.php",
        "src/Generator/GenerationPlan.php",
        "src/Generator/PlanApplier.php",
      ),
    )[
      #given[#the(Generator) has produced `Generated/Model/Pet.php` from a prior schema that declared a `Pet` component]
      #when[#the(Generator) runs again with a schema from which the `Pet` component has been removed]
      #then[`Generated/Model/Pet.php` is no longer on disk]
      #and_[files placed alongside `Generated/` under the same `output` directory are untouched]
    ]
  ]
]
