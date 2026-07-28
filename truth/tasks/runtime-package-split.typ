#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Split the generated-code runtime out of the generator package",
  tags: ("packaging", "dx"),
  priority: 6,
  difficulty: 6,
  status: proposed(2026, 7, 28),
)

== Summary

Generated code depends on the marshalling runtime and the runtime attributes, which ship inside the single generator package. A consumer of a generated client therefore takes a production dependency on the whole generator, dragging in the OpenAPI parser, the PHP code-generation library and a diffing library — none of which any generated line uses at run time. That is a real cost to impose on a downstream application, and it has to be resolved before the project is published.

== Acceptance criteria

- The runtime is a separate installable package containing only what generated code needs at run time.
- The generator depends on the runtime; the runtime depends on neither the parser nor the code generator nor the differ.
- A generated client installs and runs with the runtime alone, verified by installing it into a scratch project with the generator absent.
- A consumer installs the generator only as a development dependency.
- Namespaces emitted into generated files point at the runtime package.

== Non-goals

- Publishing either package to the registry; that is release work.
- Splitting the repository — a single repository with two packages is acceptable.

== Files

- \`composer.json\`
- \`src/Runtime/\`
- \`src/Generator/Emit/ModelEmitter.php\`
- \`src/Generator/Emit/ClientEmitter.php\`
