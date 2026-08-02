#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "form urlencoded body requires the literal type object keyword",
  tags: ("generator", "strictness"),
  priority: 4,
  difficulty: 3,
  status: proposed(2026, 8, 2),
)

== Summary

RequestBodyAnalyzer requires a literal type: object keyword before it will read a form-urlencoded body's properties, at RequestBodyAnalyzer.php lines 153 and 216. A form body declaring properties without the keyword is refused.

This is the fourth site of the root cause close-the-three-sites-that-widen-a-declared-shape closed at the other three: reading the type keyword alone, when JSON Schema does not require it and vendors routinely omit it. That task introduced ObjectShape, which asks the object question once — the type keyword, declared properties, or a value schema under additionalProperties — and routed the type resolver, the component catalogue, the property synthesiser, the payload planner and the response analyser through it. The form-urlencoded path was left out deliberately, because it refuses rather than widens, and a refusal is honest under fail-loud-never-silent.

Honest, and still wrong: the schema declares an object shape by every reading other than the keyword, and paogen can represent it. No vendored document exercises it today, which is why this is filed rather than hotfixed.

== Acceptance criteria

- A form-urlencoded request body whose schema declares properties without a type keyword emits the same form fields as the identical schema with the keyword. Proven by two fixtures differing only in the keyword.
- The refusal survives for a schema that genuinely declares no object shape — no type, no properties, no additionalProperties value schema. That case still refuses by name.
- The decision runs through ObjectShape rather than a fourth local reading of the keyword, and SchemaType stays the single reader of a type keyword in src/.

== Non-goals

- Any other form-encoding behaviour: encoding objects, arrays, or the encoding object's style and explode keywords.
- multipart/form-data, which represent-non-json-request-and-response-bodies owns.

== Files

- src/Generator/Emit/RequestBodyAnalyzer.php
- src/Generator/Emit/ObjectShape.php
- tests/fixtures/
