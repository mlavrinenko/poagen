<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Naming;

/**
 * Folds a raw schema name's non-ASCII letters to ASCII before the sanitisers
 * split it into words.
 *
 * PHP would accept `Клиенты` as a class name. The result would be unusable — not
 * because the language objects, but because the people reading, importing and
 * grepping the emitted tree do. So a name that is not ASCII gets transliterated
 * rather than passed through.
 *
 * Deliberately a character table and not a library. `intl`'s transliterator
 * would be shorter, but its output depends on the ICU version installed, and
 * `regeneration-is-deterministic-and-total` requires identical bytes independent
 * of the machine. A fixed table cannot drift.
 *
 * The coverage is what the corpus needs and no more: Cyrillic, because that is
 * what the kilbil loyalty document uses, and the Latin-1 accented range, because
 * European vendor documents reach for it constantly. A script outside the table
 * folds to nothing, and that is deliberate too — the caller then finds no legal
 * identifier and fails, naming the tag and asking for a rename, rather than
 * inventing `Tag7`. Guessing a readable name for a script paogen cannot read is
 * exactly what `real-world-schemas` says not to do.
 *
 * @internal
 */
final readonly class AsciiFolder
{
    /**
     * Cyrillic → Latin, following the widely-used BGN/PCGN-style romanisation
     * rather than strict ISO 9, because the point is a name a developer can read
     * and type. Uppercase forms map to a capitalised digraph so a word-initial
     * `Щ` reads `Shch` and not `SHCH`; the sanitisers recase everything
     * afterwards anyway.
     *
     * @var array<string,string>
     */
    private const array CYRILLIC = [
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e',
        'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k',
        'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r',
        'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'kh', 'ц' => 'ts',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ъ' => '', 'ы' => 'y', 'ь' => '',
        'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
        'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K',
        'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R',
        'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'Kh', 'Ц' => 'Ts',
        'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Shch', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '',
        'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
        // Ukrainian and Belarusian letters absent from the Russian alphabet, so a
        // neighbouring vendor's document does not fall off the table.
        'і' => 'i', 'І' => 'I', 'ї' => 'yi', 'Ї' => 'Yi', 'є' => 'ye', 'Є' => 'Ye',
        'ґ' => 'g', 'Ґ' => 'G', 'ў' => 'u', 'Ў' => 'U',
    ];

    /**
     * The Latin-1 supplement and Latin Extended-A letters, folded to their base
     * letter. `ß` and the ligatures expand rather than fold, because dropping a
     * letter changes the word.
     *
     * @var array<string,string>
     */
    private const array LATIN = [
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
        'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
        'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o',
        'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
        'ý' => 'y', 'ÿ' => 'y', 'ñ' => 'n', 'ç' => 'c', 'š' => 's', 'ž' => 'z',
        'ł' => 'l', 'đ' => 'd', 'ð' => 'd', 'þ' => 'th',
        'æ' => 'ae', 'œ' => 'oe', 'ß' => 'ss',
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A',
        'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
        'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
        'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O',
        'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U',
        'Ý' => 'Y', 'Ñ' => 'N', 'Ç' => 'C', 'Š' => 'S', 'Ž' => 'Z',
        'Ł' => 'L', 'Đ' => 'D', 'Ð' => 'D', 'Þ' => 'Th',
        'Æ' => 'Ae', 'Œ' => 'Oe',
    ];

    /**
     * Returns the input unchanged when it is already ASCII, so a document that
     * never needed folding cannot be churned by a future change to the table.
     */
    public static function fold(string $raw): string
    {
        if (preg_match('//u', $raw) !== 1) {
            // Not valid UTF-8; leave it alone and let the caller's split drop
            // whatever is not an identifier character.
            return $raw;
        }

        if (mb_check_encoding($raw, 'ASCII')) {
            return $raw;
        }

        return strtr($raw, self::CYRILLIC + self::LATIN);
    }
}
