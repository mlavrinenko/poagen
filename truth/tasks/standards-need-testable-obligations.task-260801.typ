#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Replace the standards' prose opt-outs with testable obligations",
  tags: ("standards", "speconaut"),
  priority: 7,
  difficulty: 5,
  status: proposed(2026, 8, 1),
)

== Summary

\`give-the-uncovered-standards-an-obligation\` (commit d23050c) closed a coverage warning on three standards that declared no testable obligation. Its acceptance criteria offered three routes: a \`\#v(...)\` rule value exercised by a real scenario, a \`requires-cases:\` entry with a matching scenario, or a \`structural:\` reason. \`silence-means-success\` got the first kind of route done properly — \`requires-cases:\` backed by two real scenarios. \`caller-surface-is-injectable\` and \`guidance-is-data-not-code\` both got \`structural:\` prose instead: paragraphs naming source classes that supposedly enforce the rule.

The cost of that choice is real. No scenario will ever cite either standard, \`speconaut check\` is satisfied by unverified prose, and that prose has already drifted once — \`caller-surface-is-injectable\`'s rule body still names the retired pre-transport collaborators (the message factories, the base address, the hydration machinery) while its own \`structural:\` slot, added the same session, correctly names the transport alone. \`pre-transport-claims-survive-the-sweep\` owns fixing that specific drift; this task owns the structural problem that let it happen silently — a standard with only prose enforcement has nothing that would have caught the contradiction.

A second, sharper case sits inside \`guidance-is-data-not-code\`. Its rule says guidance is "never executed as a template, a hook, or a callback that shapes output" and that the Generator "may not hand control to what the consumer wrote." Its \`structural:\` slot then carves out \`Profile\`'s \`nameNormaliser\` field (ADR-003) — a consumer-supplied strategy object the Generator does call — as "a bounded exception worth naming rather than hiding." The exception is real and predates the standard. But it lives in the enforcement note, not the rule, so the rule still reads as an absolute that forbids exactly what the project already does on purpose. \`adopt-jscpd-duplication-gate\` cited that absolute reading — "a per-project callback hook \[...\] which guidance-is-data-not-code forbids in as many words" — to reject a design, which is the carve-out's dishonesty doing real work on a decision that had nothing to do with \`nameNormaliser\`.

Where a testable obligation can be added, it should be — that is the standing preference this task acts on, not a reopening of the coverage question \`give-the-uncovered-standards-an-obligation\` already settled for \`silence-means-success\`.

== Acceptance criteria

- For \`caller-surface-is-injectable\`, a testable obligation is added if one can genuinely be devised: a \`requires-cases:\` entry paired with a scenario that asserts the interface-plus-constructor-injection shape directly, or a \`\#v(...)\` rule value an \`unstable\` scenario exercises. The \`structural:\` prose stays only as a supplement, not the sole enforcement.
- The same attempt is made for \`guidance-is-data-not-code\`. If no testable obligation is achievable for either standard after a genuine attempt, this task's Result section says why, rather than the task quietly closing back onto prose the way the prior task did.
- \`guidance-is-data-not-code\`'s rule body is edited so the \`nameNormaliser\` exception is legible from the rule itself — either the exception is written into the rule text, or the rule is narrowed (for example to "guidance may not contribute to emitted behaviour") so \`nameNormaliser\` is inside it rather than a carve-out against it. Nothing about the rule's absolute wording survives that a reader could still misapply the way \`adopt-jscpd-duplication-gate\` did.
- \`adopt-jscpd-duplication-gate\`'s citation of the old absolute reading is checked against the corrected rule and noted in this task's Result section; if the correction would have changed what that task could have proposed, that is recorded, not silently reopened — any actual jscpd design change belongs to \`jscpd-as-a-real-gate\`.
- \`speconaut check truth/\` still reports zero standards-coverage warnings on all three standards \`give-the-uncovered-standards-an-obligation\` touched.

== Non-goals

- Does not revisit \`silence-means-success\`'s \`requires-cases:\` treatment, which already works and is not in question.
- Does not widen \`guidance-is-data-not-code\` to bless any callback-shaped extension point beyond \`nameNormaliser\`; it only makes the existing, already-accepted exception honest in the rule text.
- Does not redesign the jscpd marker-emission proposal \`adopt-jscpd-duplication-gate\` rejected — \`jscpd-as-a-real-gate\` owns jscpd's own follow-on work.
- Does not fix \`caller-surface-is-injectable\`'s pre-transport wording drift; \`pre-transport-claims-survive-the-sweep\` already owns that correction.

== Files

- \`truth/standards/caller-surface-is-injectable.standard-260729.typ\`
- \`truth/standards/guidance-is-data-not-code.standard-260729.typ\`
- \`truth/specs/\`
- \`truth/tasks/adopt-jscpd-duplication-gate.task-260730.typ\`
