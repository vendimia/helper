<?php

namespace Vendimia\Helper;

use Stringable;

/**
 * Extract the text from a DocComment block.
 *
 * Each
 */
class TextFromDocComment implements Stringable
{
    /** Extracted text */
    public string $text = '';

    public function __construct(
        string $doc_comment,
        bool $merge_lines = true
    )
    {
        $result = [];
        $lines = explode("\n", $doc_comment);

        // Si solo hay una línea, removemos los caracteres de ámbos lados
        if (count($lines) == 1) {
            $this->text = trim($doc_comment, '/* ');
            return;
        }

        $last_line = '';

        foreach ($lines as $line) {
            $pline = trim($line);

            // Si la línea empieza con un '/**', lo eliminamos
            if (str_starts_with($pline, '/**')) {
                $pline = substr($pline, 3);

                // Si el resultado es vacío, lo ignoramos
                if (!$pline) {
                    continue;
                }
            }

            // Si la línea acaba con un */, lo eliminamos
            if (str_ends_with($pline, '*/')) {
                $pline = substr($pline, 1, -2);
            }

            // Si la línea empieza con un '*', lo eliminamos
            if (str_starts_with($pline, '*')) {
                $pline = trim(substr($pline, 1));
            }

            // Líneas vacías añaden un nuevo párrafo.

            if ($merge_lines) {
                if ($pline == "") {
                    $last_line = trim($last_line);
                    if ($last_line) {
                        $result[] = $last_line;
                        $last_line = '';
                    }
                } else {
                    $last_line .= $pline . ' ';
                }
            } else {
                $result[] = trim($pline);
            }
        }
        $this->text = trim(join("\n", $result));
    }

    public function __toString(): string
    {
        return $this->text;
    }
}
