#import "@local/speconaut:0.1.0": *
#import "../domain/schema.context.typ": schema-context, Schema
#import "../domain/guidance.context.typ": guidance-context, Profile, ValueObject, AttributeScan

#feature("Profile", description: [
  The generator is a pure function of #the(Schema) and #the(Profile).
  This feature covers loading and validating #the(Profile), and discovering
  user-side bindings declared via attributes on user value objects.
])[

  #rule("Loading a Profile")[
    #scenario(
      "A PHP file that returns a Profile is loaded as that Profile",
      stage: "unstable",
    )[
      #given[a PHP file at #p((path: "<profile-path>")) returns #a(Profile) for #the(Schema) at #p((schema: "<schema-path>"))]
      #when[#the(Profile) is loaded from that path]
      #then[the result is #a(Profile)]
      #and_[#the(Profile.schema) resolves to the fixture path]
    ]

    #scenario(
      "A PHP file that does not return a Profile is rejected",
      stage: "unstable",
    )[
      #given[a PHP file that returns the integer #p((value: "42")) instead of #a(Profile)]
      #when[loading #the(Profile) from that path is attempted]
      #then[loading #the(Profile) throws #p((error: "InvalidProfileException"))]
    ]
  ]

  #rule("Discovering user value-object bindings")[
    #scenario(
      "A user class with BindsFormat in a discovered namespace registers a format binding",
      stage: "unstable",
    )[
      #given[#a(ValueObject) class is annotated with #p((attr: "#[BindsFormat('email')]"))]
      #and_[its namespace is listed in #the(Profile)'s `discoverIn`]
      #when[#the(AttributeScan) runs over #the(Profile)]
      #then[the resulting binding map contains #p((format: "email")) → that #the(ValueObject)]
    ]

    #scenario(
      "A class outside discoverIn is ignored even if annotated",
      stage: "unstable",
    )[
      #given[#a(ValueObject) class is annotated with #p((attr: "#[BindsFormat('uuid')]"))]
      #and_[its namespace is *not* listed in #the(Profile)'s `discoverIn`]
      #when[#the(AttributeScan) runs over #the(Profile)]
      #then[the resulting binding map does not contain #p((format: "uuid")) for that #the(ValueObject)]
    ]
  ]
]
