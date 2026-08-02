#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "nullable type array is lost in property synthesis",
  tags: ("generator", "openapi-31", "strictness"),
  priority: 8,
  difficulty: 4,
  status: proposed(2026, 8, 2),
)

== Summary

Found by kilbil-recorded-response-proof, reproduced against the real generated client and the real HttpTransport rather than inferred from source. TypeResolver::resolve() honours both spellings of nullability at src/Generator/Emit/TypeResolver.php:55, where it computes nullable as the 3.0 nullable flag OR SchemaType::of(node)->nullable, the 3.1 type array form. PropertySynthesiser does not. At src/Generator/Emit/PropertySynthesiser.php:59 it computes nullable from (bool) propSchema->nullable alone and never consults SchemaType, then passes that value into both the synthesised-enum branch and the synthesised-object branch. So every property PropertySynthesiser resolves itself, rather than delegating to TypeResolver, emits a non-nullable PHP type even though its schema declares type: \[T, null\]. The consequence is not cosmetic. A spec-compliant server sending JSON null for such a property throws TypeError out of the constructor. Two are confirmed on the kilbil document: the searchClient response's state, declared type: \[string, null\] at schemas/loyalty\_v1.yaml lines 365-379, and special\_days\_types, declared type: \[array, null\] at lines 721-726 with the vendor's own description saying null if none. This is the gap nullable-type-arrays was meant to close. That task fixed the reading in TypeResolver and 87 properties depended on it; the synthesis path was missed, and nothing caught it because no test had ever hydrated a real vendor payload.

== Acceptance criteria

- PropertySynthesiser derives nullability the same way TypeResolver does, from the 3.0 flag or the 3.1 type array, for every branch it resolves itself: synthesised enum, synthesised object, and array item.
- A null wire value for the kilbil searchClient response's state and special\_days\_types hydrates to null instead of throwing TypeError. The two probes in tests/Integration/Kilbil/KilbilNullableTypeArrayDefectTest.php are written to fail loudly if the defect is fixed and they are not updated, so use them as the regression test rather than writing new ones.
- A fixture covers the shape directly, so the guarantee does not depend on the kilbil document staying in the repository. Both branches PropertySynthesiser owns need one: an inline enum and an inline object, each declared type: \[T, null\].
- The duplication is removed rather than repaired twice. If both sites now compute the same thing, they should call the same thing, so a third synthesis path cannot reintroduce this.
- Regenerating the kilbil tree changes only the affected property types, and that diff is reviewed and committed as intended.

== Non-goals

- The 3.1 parser swap, which swap-openapi-parser-for-31-support owns and which is postponed.
- Any other difference between TypeResolver and PropertySynthesiser beyond nullability.
- The kilbil proof itself, which is a separate task and is what found this.

== Files

- src/Generator/Emit/PropertySynthesiser.php
- src/Generator/Emit/TypeResolver.php
- examples/kilbil/generated/
- tests/fixtures/
- tests/Integration/Kilbil/KilbilNullableTypeArrayDefectTest.php
