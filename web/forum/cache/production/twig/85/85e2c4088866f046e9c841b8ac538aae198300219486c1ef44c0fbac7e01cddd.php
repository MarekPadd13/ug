<?php

/* profile_send_email.txt */
class __TwigTemplate_4557129141c06778a5e3c7116130abc7aee3d599c4ef9368faf1712e15e78b52 extends Twig_Template
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
        echo "Здравствуйте, ";
        echo ($context["TO_USERNAME"] ?? null);
        echo "!

Ниже следует письмо, отправленное вам пользователем ";
        // line 3
        echo ($context["FROM_USERNAME"] ?? null);
        echo " через вашу учётную запись на конференции «";
        echo ($context["SITENAME"] ?? null);
        echo "». Если это сообщение является спамом, содержит оскорбления или другие неприятные вам высказывания, пожалуйста, свяжитесь с администратором конференции по адресу:

";
        // line 5
        echo ($context["BOARD_CONTACT"] ?? null);
        echo "

Включите данное сообщение целиком (особенно заголовки). Пожалуйста, учтите, что обратный адрес этого письма принадлежит пользователю ";
        // line 7
        echo ($context["FROM_USERNAME"] ?? null);
        echo ".

Посланное вам сообщение:
~~~~~~~~~~~~~~~~~~~~~~~~

";
        // line 12
        echo ($context["MESSAGE"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "profile_send_email.txt";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  45 => 12,  37 => 7,  32 => 5,  25 => 3,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "profile_send_email.txt", "");
    }
}
