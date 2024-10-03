<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Vendimia\Helper\TextFromDocComment;

final class TextFromDocCommentTest extends TestCase
{
    public function testEmptyDocBlock(): void
    {
        $this->assertEquals(
            (new TextFromDocComment('/** */'))->text,
            ''
        );
    }

    public function testSingleLine(): void
    {
        $this->assertEquals(
            'Este es un DocComment',
            (new TextFromDocComment('/** Este es un DocComment */'))->text,
        );
    }

    public function testJoinedMultiLine(): void
    {
        $doc_comment = <<<EOF
        /**
         * Extract the text from a DocComment block, removing asterisk and trailing
         * blank lines
         */
        EOF;

        $this->assertEquals(
            "Extract the text from a DocComment block, removing asterisk and trailing blank lines",
            (new TextFromDocComment($doc_comment))->text,
        );
    }

    public function testMultiLine(): void
    {
        $doc_comment = <<<EOF
        /**
         * Extract the text from a DocComment block, removing asterisk and trailing
         * blank lines.
         */
        EOF;

        $this->assertEquals(
            <<<EOF
            Extract the text from a DocComment block, removing asterisk and trailing
            blank lines.
            EOF,
            (new TextFromDocComment($doc_comment, merge_lines: false))->text,
        );
    }

    public function testJoinedMultiParagraph(): void
    {
        $doc_comment = <<<'EOF'
        /**
         * Extract the text from a DocComment block.
         *
         * This is a sample paragraph that should be returned
         * in one single line.
         *
         * Other single-line paragraphs should work, also.
         *
         */
        EOF;

        $this->assertEquals(
            <<<'EOF'
            Extract the text from a DocComment block.
            This is a sample paragraph that should be returned in one single line.
            Other single-line paragraphs should work, also.
            EOF,
            (new TextFromDocComment($doc_comment))->text,
        );
    }
}
