<?php

/* viewonline_body.html */
class __TwigTemplate_1439a317809b9f0b7659b1f99ecae4a65fa2c42030557caaf2d2ee470c7d8b85 extends Twig_Template
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
        $location = "overall_header.html";
        $namespace = false;
        if (strpos($location, '@') === 0) {
            $namespace = substr($location, 1, strpos($location, '/') - 1);
            $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
            $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
        }
        $this->loadTemplate("overall_header.html", "viewonline_body.html", 1)->display($context);
        if ($namespace) {
            $this->env->setNamespaceLookUpOrder($previous_look_up_order);
        }
        // line 2
        echo "
<h2 class=\"viewonline-title\">";
        // line 3
        echo ($context["TOTAL_REGISTERED_USERS_ONLINE"] ?? null);
        echo "</h2>
<p>";
        // line 4
        echo ($context["TOTAL_GUEST_USERS_ONLINE"] ?? null);
        if (($context["S_SWITCH_GUEST_DISPLAY"] ?? null)) {
            echo " &bull; <a href=\"";
            echo ($context["U_SWITCH_GUEST_DISPLAY"] ?? null);
            echo "\">";
            echo $this->env->getExtension('phpbb\template\twig\extension')->lang("SWITCH_GUEST_DISPLAY");
            echo "</a>";
        }
        echo "</p>

<div class=\"action-bar bar-top\">
\t<div class=\"pagination\">
\t\t";
        // line 8
        if (twig_length_filter($this->env, $this->getAttribute(($context["loops"] ?? null), "pagination", array()))) {
            // line 9
            echo "\t\t\t";
            $location = "pagination.html";
            $namespace = false;
            if (strpos($location, '@') === 0) {
                $namespace = substr($location, 1, strpos($location, '/') - 1);
                $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
                $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
            }
            $this->loadTemplate("pagination.html", "viewonline_body.html", 9)->display($context);
            if ($namespace) {
                $this->env->setNamespaceLookUpOrder($previous_look_up_order);
            }
            // line 10
            echo "\t\t";
        } else {
            // line 11
            echo "\t\t\t";
            echo ($context["PAGE_NUMBER"] ?? null);
            echo "
\t\t";
        }
        // line 13
        echo "\t</div>
</div>

<div class=\"forumbg forumbg-table\">
\t<div class=\"inner\">

\t<table class=\"table1\">

\t";
        // line 21
        if (twig_length_filter($this->env, $this->getAttribute(($context["loops"] ?? null), "user_row", array()))) {
            // line 22
            echo "\t\t<thead>
\t\t<tr>
\t\t\t<th class=\"name\"><a href=\"";
            // line 24
            echo ($context["U_SORT_USERNAME"] ?? null);
            echo "\">";
            echo $this->env->getExtension('phpbb\template\twig\extension')->lang("USERNAME");
            echo "</a></th>
\t\t\t<th class=\"info\"><a href=\"";
            // line 25
            echo ($context["U_SORT_LOCATION"] ?? null);
            echo "\">";
            echo $this->env->getExtension('phpbb\template\twig\extension')->lang("FORUM_LOCATION");
            echo "</a></th>
\t\t\t<th class=\"active\"><a href=\"";
            // line 26
            echo ($context["U_SORT_UPDATED"] ?? null);
            echo "\">";
            echo $this->env->getExtension('phpbb\template\twig\extension')->lang("LAST_UPDATED");
            echo "</a></th>
\t\t</tr>
\t\t</thead>
\t\t<tbody>
\t\t";
            // line 30
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["loops"] ?? null), "user_row", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["user_row"]) {
                // line 31
                echo "\t\t<tr class=\"";
                if (($this->getAttribute($context["user_row"], "S_ROW_COUNT", array()) % 2 == 1)) {
                    echo "bg1";
                } else {
                    echo "bg2";
                }
                echo "\">
\t\t\t<td>";
                // line 32
                echo $this->getAttribute($context["user_row"], "USERNAME_FULL", array());
                if ($this->getAttribute($context["user_row"], "USER_IP", array())) {
                    echo " <span style=\"float: ";
                    echo ($context["S_CONTENT_FLOW_END"] ?? null);
                    echo ";\">";
                    echo $this->env->getExtension('phpbb\template\twig\extension')->lang("IP");
                    echo $this->env->getExtension('phpbb\template\twig\extension')->lang("COLON");
                    echo " <a href=\"";
                    echo $this->getAttribute($context["user_row"], "U_USER_IP", array());
                    echo "\">";
                    echo $this->getAttribute($context["user_row"], "USER_IP", array());
                    echo "</a> &#187; <a href=\"";
                    echo $this->getAttribute($context["user_row"], "U_WHOIS", array());
                    echo "\" onclick=\"popup(this.href, 750, 500); return false;\">";
                    echo $this->env->getExtension('phpbb\template\twig\extension')->lang("WHOIS");
                    echo "</a></span>";
                }
                // line 33
                echo "\t\t\t\t";
                if ($this->getAttribute($context["user_row"], "USER_BROWSER", array())) {
                    echo "<br />";
                    echo $this->getAttribute($context["user_row"], "USER_BROWSER", array());
                }
                echo "</td>
\t\t\t<td class=\"info\"><a href=\"";
                // line 34
                echo $this->getAttribute($context["user_row"], "U_FORUM_LOCATION", array());
                echo "\">";
                echo $this->getAttribute($context["user_row"], "FORUM_LOCATION", array());
                echo "</a></td>
\t\t\t<td class=\"active\">";
                // line 35
                echo $this->getAttribute($context["user_row"], "LASTUPDATE", array());
                echo "</td>
\t\t</tr>
\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['user_row'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 38
            echo "\t";
        } else {
            // line 39
            echo "\t\t<tbody>
\t\t<tr class=\"bg1\">
\t\t\t<td colspan=\"3\">";
            // line 41
            echo $this->env->getExtension('phpbb\template\twig\extension')->lang("NO_ONLINE_USERS");
            if (($context["S_SWITCH_GUEST_DISPLAY"] ?? null)) {
                echo " &bull; <a href=\"";
                echo ($context["U_SWITCH_GUEST_DISPLAY"] ?? null);
                echo "\">";
                echo $this->env->getExtension('phpbb\template\twig\extension')->lang("SWITCH_GUEST_DISPLAY");
                echo "</a>";
            }
            echo "</td>
\t\t</tr>
\t";
        }
        // line 44
        echo "\t</tbody>
\t</table>

\t</div>
</div>

";
        // line 50
        if (($context["LEGEND"] ?? null)) {
            echo "<p><em>";
            echo $this->env->getExtension('phpbb\template\twig\extension')->lang("LEGEND");
            echo $this->env->getExtension('phpbb\template\twig\extension')->lang("COLON");
            echo " ";
            echo ($context["LEGEND"] ?? null);
            echo "</em></p>";
        }
        // line 51
        echo "
<div class=\"action-bar bar-bottom\">
\t<div class=\"pagination\">
\t\t";
        // line 54
        if (twig_length_filter($this->env, $this->getAttribute(($context["loops"] ?? null), "pagination", array()))) {
            // line 55
            echo "\t\t\t";
            $location = "pagination.html";
            $namespace = false;
            if (strpos($location, '@') === 0) {
                $namespace = substr($location, 1, strpos($location, '/') - 1);
                $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
                $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
            }
            $this->loadTemplate("pagination.html", "viewonline_body.html", 55)->display($context);
            if ($namespace) {
                $this->env->setNamespaceLookUpOrder($previous_look_up_order);
            }
            // line 56
            echo "\t\t";
        } else {
            // line 57
            echo "\t\t\t";
            echo ($context["PAGE_NUMBER"] ?? null);
            echo "
\t\t";
        }
        // line 59
        echo "\t</div>
</div>

";
        // line 62
        $location = "jumpbox.html";
        $namespace = false;
        if (strpos($location, '@') === 0) {
            $namespace = substr($location, 1, strpos($location, '/') - 1);
            $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
            $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
        }
        $this->loadTemplate("jumpbox.html", "viewonline_body.html", 62)->display($context);
        if ($namespace) {
            $this->env->setNamespaceLookUpOrder($previous_look_up_order);
        }
        // line 63
        $location = "overall_footer.html";
        $namespace = false;
        if (strpos($location, '@') === 0) {
            $namespace = substr($location, 1, strpos($location, '/') - 1);
            $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
            $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
        }
        $this->loadTemplate("overall_footer.html", "viewonline_body.html", 63)->display($context);
        if ($namespace) {
            $this->env->setNamespaceLookUpOrder($previous_look_up_order);
        }
    }

    public function getTemplateName()
    {
        return "viewonline_body.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  250 => 63,  238 => 62,  233 => 59,  227 => 57,  224 => 56,  211 => 55,  209 => 54,  204 => 51,  195 => 50,  187 => 44,  174 => 41,  170 => 39,  167 => 38,  158 => 35,  152 => 34,  144 => 33,  126 => 32,  117 => 31,  113 => 30,  104 => 26,  98 => 25,  92 => 24,  88 => 22,  86 => 21,  76 => 13,  70 => 11,  67 => 10,  54 => 9,  52 => 8,  38 => 4,  34 => 3,  31 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "viewonline_body.html", "");
    }
}
