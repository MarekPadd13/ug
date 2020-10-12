<?php

/* contact_admin.txt */
class __TwigTemplate_1cf3ba8b59fad8d8dac4d2b739b103ab95d1747274c918ef87d0a90f944ce6f2 extends Twig_Template
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
        echo "
Здравствуйте, ";
        // line 2
        echo ($context["TO_USERNAME"] ?? null);
        echo ",

Следующее сообщение отправлено с помощью страницы для связи с администрацией на сайте «";
        // line 4
        echo ($context["SITENAME"] ?? null);
        echo "».

";
        // line 6
        if (($context["S_IS_REGISTERED"] ?? null)) {
            // line 7
            echo "Сообщение отправлено с учётной записи на сайте.
Имя пользователя: ";
            // line 8
            echo ($context["FROM_USERNAME"] ?? null);
            echo "
E-mail адрес: ";
            // line 9
            echo ($context["FROM_EMAIL_ADDRESS"] ?? null);
            echo "
IP адрес: ";
            // line 10
            echo ($context["FROM_IP_ADDRESS"] ?? null);
            echo "
Профиль: ";
            // line 11
            echo ($context["U_FROM_PROFILE"] ?? null);
            echo "
";
        } else {
            // line 13
            echo "Сообщение отправлено гостем, который оставил следующую контактную информацию:
Имя: ";
            // line 14
            echo ($context["FROM_USERNAME"] ?? null);
            echo "
E-mail адрес: ";
            // line 15
            echo ($context["FROM_EMAIL_ADDRESS"] ?? null);
            echo "
IP адрес: ";
            // line 16
            echo ($context["FROM_IP_ADDRESS"] ?? null);
            echo "
";
        }
        // line 18
        echo "

Отправленное сообщение
~~~~~~~~~~~~~~~~~~~~~~~~~~~

";
        // line 23
        echo ($context["MESSAGE"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "contact_admin.txt";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  77 => 23,  70 => 18,  65 => 16,  61 => 15,  57 => 14,  54 => 13,  49 => 11,  45 => 10,  41 => 9,  37 => 8,  34 => 7,  32 => 6,  27 => 4,  22 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "contact_admin.txt", "");
    }
}
