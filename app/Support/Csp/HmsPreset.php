<?php

namespace App\Support\Csp;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;
use Spatie\Csp\Scheme;

/**
 * Content Security Policy for the whole app. Scripts come from this origin and carry the
 * request nonce (Vite tags use it); Alpine's standard build needs unsafe-eval for its
 * expressions. Styles allow inline because Tailwind and Alpine set style attributes.
 */
class HmsPreset implements Preset
{
    public function configure(Policy $policy): void
    {
        $policy
            ->add(Directive::DEFAULT, Keyword::SELF)
            ->add(Directive::SCRIPT, [Keyword::SELF, Keyword::UNSAFE_EVAL])
            ->addNonce(Directive::SCRIPT)
            ->add(Directive::STYLE, [Keyword::SELF, Keyword::UNSAFE_INLINE])
            ->add(Directive::IMG, [Keyword::SELF, Scheme::DATA])
            ->add(Directive::FONT, Keyword::SELF)
            ->add(Directive::CONNECT, Keyword::SELF)
            ->add(Directive::FORM_ACTION, Keyword::SELF)
            ->add(Directive::BASE, Keyword::SELF)
            ->add(Directive::FRAME_ANCESTORS, Keyword::NONE)
            ->add(Directive::OBJECT, Keyword::NONE);
    }
}
