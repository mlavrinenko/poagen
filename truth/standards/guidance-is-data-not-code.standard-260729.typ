#import "@local/speconaut:0.1.0": *
#import "../domain/guidance.context.typ": *
#import "../domain/generation.context.typ": *

#show: standard.with(
  title: "Consumer guidance is data the generator reads, never code it runs",
  status: accepted(2026, 7, 29),
  contexts: (guidance-context,),
  rule: [
    Everything #a(UserFile) contributes to generation — #a(Profile), #a(BindsFormat),
    the result of #an(AttributeScan) — is read by #the(Generator) as a value and
    never executed as a template, a hook, or a callback that shapes output.
    #The(Generator) may look at what the consumer declared; it may not hand
    control to what the consumer wrote.

    One exception is named here rather than folded into enforcement notes a
    reader would not see: #a(Profile)'s name-normalising strategy (ADR-003) is
    a consumer-authored callable #the(Generator) does call, to turn a raw
    identifier into a PHP-legal name. It is bounded to that one job — it
    decides spelling only, never a field, a type, or a branch of
    #a(GeneratedFile) — and the built-in pipeline runs unchanged when the
    consumer supplies nothing, so guidance stays inert on its own even here.
    No other extension point inherits this exemption. A callback that shapes
    anything beyond an identifier's spelling — inserted comments, control
    flow, emitted structure — is exactly what "a callback that shapes output"
    above forbids, and needs its own accepted standard before it could change
    that, not an assumed ride on this one.

    Two consequences follow, and both are the point. Guidance cannot smuggle
    logic into #a(GeneratedFile), so no consumer's cleverness becomes a thing
    the next reader has to reverse-engineer out of the emitted tree. And
    guidance is inert on its own: delete every #a(UserFile) and generation
    still succeeds, producing a client that is less pleasant to use and no
    less correct.
  ],
  structural: "enforced by Profile.php, a readonly value object whose
    schema-shaping fields (renames, skip, tagRenames, tagAssignments,
    tagChoice, xmlElements, inlineModels, discriminators) are plain scalars
    and arrays, never a closure — ProfileLoader.php only requires the file to
    obtain that value and does not invoke anything on it; and by
    AttributeScanner.php, which reflects `#[BindsFormat]` off consumer classes
    and reads the attribute instance without ever calling a method on the
    scanned class. One field is a bounded exception worth naming rather than
    hiding: `Profile::$nameNormaliser` (ADR-003) lets a consumer supply a
    `NameNormaliser` strategy the generator calls to decide an identifier
    string. It shapes a name only, carries no default requirement — the
    built-in pipeline runs when it is unset, so guidance stays inert on its
    own — and contributes nothing to generated behaviour, but it is a
    consumer-authored method the generator does invoke, and any future
    extension point should be weighed against this rule rather than assumed
    to inherit this exemption.",
)
