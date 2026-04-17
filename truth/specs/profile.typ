// Feature: Profile (paogen.php)
// How users tell the generator which schema, where to put the output, and
// which of their value objects to wire in for OpenAPI formats.

#import "@local/speconaut:0.1.0": *
#import "../domain.typ": *

#feature("Profile", description: [
  The generator is a pure function of #the(Schema) and #the(Profile).
  This feature covers loading and validating #the(Profile), and discovering
  user-side bindings declared via attributes on user value objects.
])[

  #rule("Loading a Profile")[
    #scenario(
      "A PHP file that returns a Profile is loaded as that Profile",
      stage: unstable,
      traces: ("src/Generator/Profile.php", "src/Generator/ProfileLoader.php"),
    )[
      #given[a PHP file at #p((path: "tests/fixtures/profiles/petstore.php")) returns #a(Profile) for #the(Schema) at #p((schema: "tests/fixtures/schemas/petstore-3.0.yaml"))]
      #when[the loader is invoked with that path]
      #then[the result is #a(Profile)]
      #and_[its `schema` resolves to the fixture path]
    ]

    #scenario(
      "A PHP file that does not return a Profile is rejected",
      stage: unstable,
      traces: (
        "src/Generator/ProfileLoader.php",
        "src/Exception/InvalidProfileException.php",
      ),
    )[
      #given[a PHP file that returns the integer #p((value: "42"))]
      #when[the loader is invoked with that path]
      #then[the loader throws #p((error: "InvalidProfileException"))]
    ]
  ]

  #rule("Discovering user value-object bindings")[
    #scenario(
      "A user class with BindsFormat in a discovered namespace registers a format binding",
      stage: unstable,
      traces: (
        "src/Generator/Attribute/BindsFormat.php",
        "src/Generator/AttributeScanner.php",
        "src/Generator/Bindings.php",
      ),
    )[
      #given[#a(ValueObject) class is annotated with #p((attr: "#[BindsFormat('email')]"))]
      #and_[its namespace is listed in #the(Profile)'s `discoverIn`]
      #when[#the(AttributeScan) runs over #the(Profile)]
      #then[the resulting binding map contains #p((format: "email")) → that class]
    ]

    #scenario(
      "A class outside discoverIn is ignored even if annotated",
      stage: unstable,
      traces: ("src/Generator/AttributeScanner.php",),
    )[
      #given[#a(ValueObject) class is annotated with #p((attr: "#[BindsFormat('uuid')]"))]
      #and_[its namespace is *not* listed in #the(Profile)'s `discoverIn`]
      #when[#the(AttributeScan) runs over #the(Profile)]
      #then[the resulting binding map does not contain #p((format: "uuid"))]
    ]
  ]
]
