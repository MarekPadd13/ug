<?php

/* test.txt */
class __TwigTemplate_e15054e2d911c00d706ea5caa7ee02478a0b1956dae31653aa61904870e2f0e0 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "Subject: phpBB настроен для отправки email-сообщений

Здравствуйте, ";
        // line 3
        echo ($context["USERNAME"] ?? null);
        echo "!

Поздравляем! Если вы получили это письмо, значит phpBB правильно настроен для отправки email-сообщений.

Для получения помощи, обратитесь на форумы официальной русской поддержки phpBB - https://www.phpbbguru.net/community/

";
        // line 9
        echo ($context["EMAIL_SIG"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "test.txt";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  32 => 9,  23 => 3,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "test.txt", "");
    }
}
