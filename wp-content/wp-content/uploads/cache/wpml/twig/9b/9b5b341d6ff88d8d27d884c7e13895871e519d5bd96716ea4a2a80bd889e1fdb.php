<?php

namespace WPML\Core;

use \WPML\Core\Twig\Environment;
use \WPML\Core\Twig\Error\LoaderError;
use \WPML\Core\Twig\Error\RuntimeError;
use \WPML\Core\Twig\Markup;
use \WPML\Core\Twig\Sandbox\SecurityError;
use \WPML\Core\Twig\Sandbox\SecurityNotAllowedTagError;
use \WPML\Core\Twig\Sandbox\SecurityNotAllowedFilterError;
use \WPML\Core\Twig\Sandbox\SecurityNotAllowedFunctionError;
use \WPML\Core\Twig\Source;
use \WPML\Core\Twig\Template;

/* /setup/translation-options.twig */
class __TwigTemplate_4f20b52b7e3d287fafbe7aa98df7a6c31ff2b1d497088f1bf86476f2aa24a1ab extends \WPML\Core\Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<span id=\"";
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "step_id", []), "html", null, true);
        echo "\">
<h1>";
        // line 2
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "heading", []), "html", null, true);
        echo "</h1>

<p>";
        // line 4
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "description", []), "html", null, true);
        echo "</p>

<ul class=\"no-bullets\">
    <li>
        <label class=\"wcml-translate-everything";
        // line 8
        if (($context["is_translate_some_mode"] ?? null)) {
            echo " js-otgs-popover-tooltip";
        }
        echo "\"
               ";
        // line 9
        if (($context["is_translate_some_mode"] ?? null)) {
            // line 10
            echo "               data-tippy-zindex=\"999999\"
               title=\"";
            // line 11
            echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "tooltip_translate_everything", []), "html", null, true);
            echo "\"
               ";
        }
        // line 13
        echo "        >
            <input type=\"radio\" value=\"translate_everything\" name=\"translation-option\"
                ";
        // line 15
        if (($context["is_translate_some_mode"] ?? null)) {
            echo " disabled=\"disabled\"";
        }
        // line 16
        echo "            />
            ";
        // line 17
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "label_translate_everything", []), "html", null, true);
        echo "
        </label>
    </li>
    <li>
        <label class=\"wcml-translate-some\">
            <input type=\"radio\" value=\"translate_some\" name=\"translation-option\" />
            ";
        // line 23
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "label_translate_some", []), "html", null, true);
        echo "
        </label>
    </li>
    <li>
        <label class=\"wcml-display-as-translated\">
            <input type=\"radio\" value=\"display_as_translated\" name=\"translation-option\" ";
        // line 28
        if (($context["is_display_as_translated_checked"] ?? null)) {
            echo "checked=\"checked\"";
        }
        echo " />
            ";
        // line 29
        echo $this->getAttribute(($context["strings"] ?? null), "label_display_as_translated", []);
        echo "
        </label>
    </li>
</ul>

<p>";
        // line 34
        echo sprintf($this->getAttribute(($context["strings"] ?? null), "description_footer", []), "<strong>", "</strong>");
        echo "</p>

<p class=\"wcml-setup-actions step\">
    <a href=\"";
        // line 37
        echo \WPML\Core\twig_escape_filter($this->env, ($context["continue_url"] ?? null), "html", null, true);
        echo "\" class=\"button button-large button-primary submit\">";
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "continue", []), "html", null, true);
        echo "</a>
</p>
</span>";
    }

    public function getTemplateName()
    {
        return "/setup/translation-options.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  113 => 37,  107 => 34,  99 => 29,  93 => 28,  85 => 23,  76 => 17,  73 => 16,  69 => 15,  65 => 13,  60 => 11,  57 => 10,  55 => 9,  49 => 8,  42 => 4,  37 => 2,  32 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "/setup/translation-options.twig", "D:\\xampp\\htdocs\\ecommerce\\wp-content\\plugins\\woocommerce-multilingual\\templates\\setup\\translation-options.twig");
    }
}
