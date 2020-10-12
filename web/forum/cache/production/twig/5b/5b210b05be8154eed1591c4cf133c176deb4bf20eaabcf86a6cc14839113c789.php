<?php

/* user_activate_passwd.txt */
class __TwigTemplate_cbca67dfd35a8f14112f928e338e8b6e9a53021d45b354729c7475060dabc0f6 extends Twig_Template
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
        echo "Subject: Активация нового пароля

Здравствуйте, ";
        // line 3
        echo ($context["USERNAME"] ?? null);
        echo "!

Вы получили это письмо потому, что вы (либо кто-то, выдающий себя за вас) попросили выслать новый пароль для вашей учётной записи на конференции «";
        // line 5
        echo ($context["SITENAME"] ?? null);
        echo "». Если вы не просили выслать пароль, то не обращайте внимания на это письмо, если же подобные письма будут продолжать приходить, обратитесь к администратору конференции.

Прежде чем использовать новый пароль, вы должны его активировать. Для этого перейдите по ссылке:

";
        // line 9
        echo ($context["U_ACTIVATE"] ?? null);
        echo "

В случае успешной активации вы сможете входить на конференцию, используя следующий пароль:

Пароль: ";
        // line 13
        echo ($context["PASSWORD"] ?? null);
        echo "

Вы сможете сменить этот пароль на странице редактирования профиля в личном разделе. Если у вас возникнут какие-либо трудности, обратитесь к администратору конференции.

";
        // line 17
        echo ($context["EMAIL_SIG"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "user_activate_passwd.txt";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  49 => 17,  42 => 13,  35 => 9,  28 => 5,  23 => 3,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "user_activate_passwd.txt", "");
    }
}
