<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Enum;

enum CodeScanningVariantAnalysisLanguage: string
{
    case Actions = 'actions';
    case Cpp = 'cpp';
    case Csharp = 'csharp';
    case Go = 'go';
    case Java = 'java';
    case Javascript = 'javascript';
    case Python = 'python';
    case Ruby = 'ruby';
    case Rust = 'rust';
    case Swift = 'swift';
}
