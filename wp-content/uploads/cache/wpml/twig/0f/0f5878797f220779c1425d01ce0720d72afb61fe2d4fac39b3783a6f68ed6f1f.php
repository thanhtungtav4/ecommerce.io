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

/* template.twig */
class __TwigTemplate_ab6ad4c6d1c11847deeae9a3b884c733dc7786e434088c003e541b4232bf4ff9 extends \WPML\Core\Twig\Template
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
        echo "<div class=\"";
        echo \WPML\Core\twig_escape_filter($this->env, ($context["css_classes"] ?? null), "html", null, true);
        echo "\" >
\t<ul>
\t\t";
        // line 3
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["currencies"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["currency"]) {
            // line 4
            echo "\t\t\t<li ";
            if (($context["currency"] == ($context["selected_currency"] ?? null))) {
                echo " class=\"wcml-cs-active-currency\" ";
            }
            echo " >
\t\t\t\t<a rel=\"";
            // line 5
            echo \WPML\Core\twig_escape_filter($this->env, $context["currency"], "html", null, true);
            echo "\">";
            echo call_user_func_array($this->env->getFunction('get_formatted_price')->getCallable(), [$context["currency"], ($context["format"] ?? null)]);
            echo "</a>
\t\t\t</li>
\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['currency'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 8
        echo "\t</ul>
</div>";
    }

    public function getTemplateName()
    {
        return "template.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  60 => 8,  49 => 5,  42 => 4,  38 => 3,  32 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "template.twig", "D:\\Ampps\\www\\ecommerce.io\\wp-content\\plugins\\woocommerce-multilingual\\templates\\currency-switchers\\legacy-list-horizontal\\template.twig");
    }
}
