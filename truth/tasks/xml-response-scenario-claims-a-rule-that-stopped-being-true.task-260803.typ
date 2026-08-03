#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "xml response scenario claims a rule that stopped being true",
  tags: ("truth", "specs"),
  priority: 3,
  difficulty: 2,
  status: proposed(2026, 8, 3),
)

== Summary

The scenario at truth/specs/operation-generator.feature-260418.typ line 99 is titled: an application/xml response aborts the run the same way any other non-JSON response does.

It still passes, because an XML response really does abort. The clause after the comma is what stopped being true: represent-non-json-request-and-response-bodies made text/plain, text/html and text/markdown responses return a string, so they no longer abort. There is no longer a general rule about non-JSON responses for XML to be an instance of — XML is refused on its own terms, by xml-responses-refused-at-generation-time.

Found by the agent that made the other four scenarios true again, and left alone because it was outside the four it was authorised to touch.

A passing scenario whose title asserts a rule that no longer exists is worse than a failing one: nothing will ever catch it, and the next reader takes the title as current.

== Acceptance criteria

- The scenario asserts what actually holds: an XML response aborts because XML is refused at generation time, not because it is non-JSON.
- The rule the scenario sits under says the same thing, if it also generalises.
- The generated test is regenerated and the lockfile applied in the same change, since scenario text compiles into tests/generated. Editing the spec alone leaves the gate red.
- A grep of the spec tree for other scenarios claiming non-JSON responses abort returns nothing, or each hit is fixed here too.

== Non-goals

- Reopening whether XML responses should be refused. That decision stands.
- The four scenarios represent-non-json-request-and-response-bodies already corrected.

== Files

- truth/specs/operation-generator.feature-260418.typ
- tests/generated/
- .speconaut/state.lock
