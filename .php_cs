<?php

/**
 * This file is part of DiepXuan.
 *
 * @copyright (c)  2021 DiepXuan Co,.Ltd
 * @author         Tran Ngoc Duc
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

$header = <<<'EOF'
This file is part of DiepXuan.

@copyright (c)  2021 DiepXuan Co,.Ltd
@author         Tran Ngoc Duc

This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.
EOF;

return (new PhpCsFixer\Config())
    ->setRules([
        "@PSR2" => true,
        "@PhpCsFixer" => true,
        "@DoctrineAnnotation" => true,
        "array_indentation" => true,
        "array_syntax" => ["syntax" => "short"],
        "combine_consecutive_unsets" => true,
        "class_attributes_separation" => ["elements" => ["method" => "one"]],
        "multiline_whitespace_before_semicolons" => false,
        "single_quote" => true,
        "binary_operator_spaces" => [
            "operators" => [
                "=>" => "align_single_space_minimal",
                "=" => "align_single_space_minimal",
            ],
        ],
        "braces" => [
            "allow_single_line_closure" => true,
        ],
        "concat_space" => ["spacing" => "one"],
        "declare_equal_normalize" => true,
        "function_typehint_space" => true,
        "single_line_comment_style" => ["comment_types" => ["hash"]],
        "include" => true,
        "lowercase_cast" => true,
        "no_extra_blank_lines" => [
            "tokens" => ["curly_brace_block", "extra", "throw", "use"],
        ],
        "new_with_braces" => true,
        "no_empty_statement" => true,
        "no_leading_import_slash" => true,
        "no_leading_namespace_whitespace" => true,
        "multiline_whitespace_before_semicolons" => false,
        "no_singleline_whitespace_before_semicolons" => true,
        "ordered_imports" => true,
        "standardize_not_equals" => true,
        "no_multiline_whitespace_around_double_arrow" => true,
        "no_spaces_around_offset" => true,
        "no_trailing_comma_in_singleline_array" => true,
        "no_unused_imports" => true,
        "no_whitespace_before_comma_in_array" => true,
        "no_whitespace_in_blank_line" => true,
        "object_operator_without_whitespace" => true,
        "ternary_operator_spaces" => true,
        "trim_array_spaces" => true,
        "unary_operator_spaces" => true,
        "whitespace_after_comma_in_array" => true,
        "space_after_semicolon" => true,
        "single_blank_line_at_eof" => true,
        "header_comment" => [
            "header" => $header,
            "comment_type" => "PHPDoc",
            "location" => "after_open",
            "separate" => "bottom",
        ],
    ])
    ->setLineEnding(PHP_EOL);
