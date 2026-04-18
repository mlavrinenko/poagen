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
      stage: draft,
    )[
      #given[#a(Model) #p((parent: "Pet")) declares an inline property `shipping` with `type: object` and nested properties #p((props: "address: string, zip: string"))]
      #when[the model is emitted]
      #then[a class `Generated/Model/PetShipping.php` is written]
      #and_[`Pet` has a promoted constructor parameter `PetShipping $shipping`]
      #and_[the property is *not* typed `array<string, mixed>`]
    ]

    #scenario(
      "A schema with enum values becomes a PHP 8.1 backed enum",
      stage: draft,
    )[
      #given[#the(Schema) declares a named component `Status` with `type: string` and #p((enum: "[available, pending, sold]"))]
      #when[#the(Generator) runs against #the(Profile)]
      #then[a file `Generated/Enum/Status.php` is written]
      #and_[the emitted enum is `enum Status: string` with one case per declared value]
      #and_[operations and Models that reference `#/components/schemas/Status` are typed with the enum, not `string`]
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
  ]

  #rule("Re-running the generator is byte-stable")[
    #scenario(
      "Running the generator twice with the same inputs produces identical files",
      stage: unstable,
      traces: ("src/Generator/Generator.php",),
    )[
      #given[#the(Generator) has run once and produced #the(GeneratedFile) tree]
      #when[#the(Generator) runs again with the same #the(Schema) and #the(Profile)]
      #then[every file under #the(Profile)'s `output` is byte-for-byte identical to the previous run]
    ]
  ]
]
