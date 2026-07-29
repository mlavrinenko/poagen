#import "@local/speconaut:0.1.0": *
#import "../domain/guidance.context.typ": *
#import "../domain/schema.context.typ": *

#show: standard.with(
  title: "Validation schemas are committed exactly as published",
  status: accepted(2026, 7, 29),
  contexts: (schema-context,),
  rule: [
    #A(Schema) used to demonstrate that paogen works is committed byte-for-byte
    as its vendor published it. It is not reformatted, not trimmed to the parts
    that generate cleanly, not repaired where it is sloppy, and not bundled
    through a tool that normalises it first.

    A hand-adjusted fixture proves only that paogen handles schemas paogen
    already likes, which is the one claim nobody needs. Real documents carry
    inline payloads, absent operation identifiers, tags applied unevenly, and
    constructs their authors never validated — and handling those is the whole
    difference between a demonstration and a tool. Where #a(Schema) needs
    adjusting to generate, the adjustment belongs in #a(Profile) as recorded
    guidance, where it is visible and survives the vendor republishing.
  ],
  structural: "enforced by the committed fixture bytes themselves; editing one shows up in review as a diff against a vendor document",
)
