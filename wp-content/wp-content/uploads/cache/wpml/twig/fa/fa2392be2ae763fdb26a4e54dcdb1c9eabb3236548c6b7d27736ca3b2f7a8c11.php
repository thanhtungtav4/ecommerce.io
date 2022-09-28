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

/* media.twig */
class __TwigTemplate_47a220594cf6dab253ae41a1a203cad9c991c446766b647c524e498603c5c6c9 extends \WPML\Core\Twig\Template
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
        echo "<div class=\"wcml-section\">
    <div class=\"wcml-section-header\">
        <h3>
            ";
        // line 4
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "heading", []), "html", null, true);
        echo "
            <i class=\"otgs-ico-help wcml-tip\" data-tip=\"";
        // line 5
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "media_tip", []));
        echo "\"></i>
        </h3>
    </div>
    <div class=\"wcml-section-content\">
        <ul class=\"wcml-status-list wcml-plugins-status-list\">
            <li>
                ";
        // line 11
        if (($context["media_translation_active"] ?? null)) {
            // line 12
            echo "                    <i class=\"otgs-ico-ok\"></i>
                    ";
            // line 13
            echo $this->getAttribute(($context["strings"] ?? null), "using_media_translation", []);
            echo "
                ";
        } else {
            // line 15
            echo "                    <i class=\"otgs-ico-warning\"></i>
                    ";
            // line 16
            echo $this->getAttribute(($context["strings"] ?? null), "not_using_media_translation", []);
            echo "
                    <p class=\"description\">";
            // line 17
            echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "why_use_media_translation", []), "html", null, true);
            echo "</p>
                ";
        }
        // line 19
        echo "            </li>
        </ul>
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "media.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  72 => 19,  67 => 17,  63 => 16,  60 => 15,  55 => 13,  52 => 12,  50 => 11,  41 => 5,  37 => 4,  32 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "media.twig", "D:\\xampp\\htdocs\\ecommerce\\wp-content\\plugins\\woocommerce-multilingual\\templates\\status\\media.twig");
    }
}
