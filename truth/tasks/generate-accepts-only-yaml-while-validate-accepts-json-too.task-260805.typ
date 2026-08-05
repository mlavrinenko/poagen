#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Generate accepts only YAML while validate accepts JSON too",
  tags: (),
  priority: 3,
  difficulty: 2,
  status: proposed(2026, 8, 5),
)

== Summary

`Cli::validate()` picks its reader by file extension — `readFromJsonFile`
for `.json`, `readFromYamlFile` otherwise (`src/Cli.php:134-136`). The
generate path does not: `Generator::plan()` calls `readFromYamlFile`
unconditionally (`src/Generator/Generator.php:65`).

Today this is invisible, because YAML 1.2 is a superset of JSON, so the
YAML reader eats a JSON document without complaint. That is an accident,
not a decision, and it is the kind that holds until it does not: a JSON
document with duplicate keys, tab indentation, or an integer wider than
YAML's implicit resolver expects parses differently through the two
readers, and the one the user validated against is not the one that
generated their client.

Found while designing a schema-patch pipeline for the kilbil client. The
question "can I hand poagen a `.json` document?" has two answers depending
on which subcommand you ask, and neither is written down. The pipeline was
built YAML-to-YAML specifically to avoid depending on the accident, which
is the right call for a consumer but leaves the inconsistency here.

== Acceptance criteria

- One code path chooses the reader, and both `validate` and `generate` use
  it. Extension-based selection is fine; two independent copies of the
  decision are not.
- A `.json` OpenAPI document generates a client identical to the one its
  YAML equivalent generates, proven by a test over both forms of the same
  document rather than by inspection.
- Whatever the answer is, README states it: either poagen accepts JSON and
  YAML equally, or it accepts YAML only and says so where the profile's
  `schema:` key is documented.
- If JSON is to be refused, `generate` fails with a message naming the
  extension — not a YAML parse error from inside the reader.

== Non-goals

- Does not add support for any other document format.
- Does not change the parser (`devizzent/cebe-php-openapi`).
- Does not touch the patch pipeline in the consuming project; that lives
  outside this repository.

== Files

- `src/Cli.php`
- `src/Generator/Generator.php`
- `tests/`
- `README.md`
