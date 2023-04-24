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

/* store-urls.twig */
class __TwigTemplate_abdc952e05c12e814a6f805a2a6ae3a8c88cbae89ca4a37bebc882d1c9f72296 extends \WPML\Core\Twig\Template
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
        echo "<div>
    <p>";
        // line 2
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "notice", []), "html", null, true);
        echo "</p>
    <p>";
        // line 3
        echo $this->getAttribute(($context["strings"] ?? null), "notice_defaults", []);
        echo "</p>
</div>
<table class=\"widefat wpml-list-table wp-list-table striped\" cellspacing=\"0\">
    <thead>
        <tr>
            <th scope=\"col\">";
        // line 8
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "slug_type", []), "html", null, true);
        echo "</th>
            <th scope=\"col\" id=\"date\" class=\"wpml-col-url\">
                ";
        // line 10
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "orig_slug", []), "html", null, true);
        echo "
            </th>
            <th scope=\"col\" class=\"wpml-col-languages\">
                ";
        // line 13
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["data"] ?? null), "flags", []));
        foreach ($context['_seq'] as $context["_key"] => $context["language"]) {
            // line 14
            echo "                    <span title=\"";
            echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["language"], "name", []));
            echo "\">
\t\t\t\t\t\t\t<img src=\"";
            // line 15
            echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["language"], "flag_url", []), "html", null, true);
            echo "\"  alt=\"";
            echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["language"], "name", []));
            echo "\"/>
\t\t\t\t\t\t</span>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['language'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 18
        echo "            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <strong>
                    ";
        // line 25
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "shop", []), "html", null, true);
        echo "
                </strong>
            </td>

            <td class=\"wpml-col-url\">
                <img src=\"";
        // line 30
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["shop_base"] ?? null), "flag", []), "html", null, true);
        echo "\" />
                <strong>";
        // line 31
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["shop_base"] ?? null), "orig_value", []), "html", null, true);
        echo "</strong>
            </td>

            <td class=\"wpml-col-languages\">
                ";
        // line 35
        echo $this->getAttribute(($context["shop_base"] ?? null), "statuses", []);
        echo "
            </td>

        </tr>
        <tr>
            <td>
                <strong>
                    ";
        // line 42
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "product", []), "html", null, true);
        echo "
                </strong>
            </td>

            <td class=\"wpml-col-url\">
                <img src=\"";
        // line 47
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["product_base"] ?? null), "flag", []), "html", null, true);
        echo "\" />
                <strong>";
        // line 48
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["product_base"] ?? null), "orig_value", []), "html", null, true);
        echo "</strong>
            </td>

            <td class=\"wpml-col-languages\">
                ";
        // line 52
        echo $this->getAttribute(($context["product_base"] ?? null), "statuses", []);
        echo "
            </td>

        </tr>
        <tr>
            <td>
                <strong>
                    ";
        // line 59
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "category", []), "html", null, true);
        echo "
                </strong>
            </td>

            <td class=\"wpml-col-url\">
                <img src=\"";
        // line 64
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["cat_base"] ?? null), "flag", []), "html", null, true);
        echo "\" />
                <strong>";
        // line 65
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["cat_base"] ?? null), "orig_value", []), "html", null, true);
        echo "</strong>
            </td>

            <td class=\"wpml-col-languages\">
                ";
        // line 69
        echo $this->getAttribute(($context["cat_base"] ?? null), "statuses", []);
        echo "
            </td>

        </tr>
        <tr>
            <td>
                <strong>
                    ";
        // line 76
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "tag", []), "html", null, true);
        echo "
                </strong>
            </td>

            <td class=\"wpml-col-url\">
                <img src=\"";
        // line 81
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["tag_base"] ?? null), "flag", []), "html", null, true);
        echo "\" />
                <strong>";
        // line 82
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["tag_base"] ?? null), "orig_value", []), "html", null, true);
        echo "</strong>
            </td>

            <td class=\"wpml-col-languages\">
                ";
        // line 86
        echo $this->getAttribute(($context["tag_base"] ?? null), "statuses", []);
        echo "
            </td>

        </tr>
        <tr>
            <td>
                <strong>
                    ";
        // line 93
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "attr", []), "html", null, true);
        echo "
                </strong>
            </td>

            <td class=\"wpml-col-url\">
                <img src=\"";
        // line 98
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["attr_base"] ?? null), "flag", []), "html", null, true);
        echo "\" />
                <strong>";
        // line 99
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["attr_base"] ?? null), "orig_value", []), "html", null, true);
        echo "</strong>
            </td>

            <td class=\"wpml-col-languages\">
                ";
        // line 103
        echo $this->getAttribute(($context["attr_base"] ?? null), "statuses", []);
        echo "
            </td>
        </tr>
        ";
        // line 106
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["endpoints_base"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["endpoint"]) {
            // line 107
            echo "            <tr>
                <td>
                    <strong>
                        ";
            // line 110
            echo \WPML\Core\twig_escape_filter($this->env, sprintf($this->getAttribute(($context["strings"] ?? null), "endpoint", []), $this->getAttribute($context["endpoint"], "key", [])), "html", null, true);
            echo "
                    </strong>
                </td>

                <td class=\"wpml-col-url\">
                    <img src=\"";
            // line 115
            echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["endpoint"], "flag", []), "html", null, true);
            echo "\" />
                    <strong>";
            // line 116
            echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["endpoint"], "orig_value", []), "html", null, true);
            echo "</strong>
                </td>

                <td class=\"wpml-col-languages\">
                    ";
            // line 120
            echo $this->getAttribute($context["endpoint"], "statuses", []);
            echo "
                </td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['endpoint'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 124
        echo "        ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["attribute_slugs"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["slug"]) {
            // line 125
            echo "            <tr>
                <td>
                    <strong>
                        ";
            // line 128
            echo \WPML\Core\twig_escape_filter($this->env, sprintf($this->getAttribute(($context["strings"] ?? null), "attribute_slug", []), $this->getAttribute($context["slug"], "label", [])), "html", null, true);
            echo "
                    </strong>
                </td>

                <td class=\"wpml-col-url\">
                    <img src=\"";
            // line 133
            echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["slug"], "flag", []), "html", null, true);
            echo "\" />
                    <strong>";
            // line 134
            echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["slug"], "orig_value", []), "html", null, true);
            echo "</strong>
                </td>

                <td class=\"wpml-col-languages\">
                    ";
            // line 138
            echo $this->getAttribute($context["slug"], "statuses", []);
            echo "
                </td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['slug'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 142
        echo "    </tbody>
</table>


";
        // line 146
        echo $this->getAttribute(($context["nonces"] ?? null), "edit_base", []);
        echo "
";
        // line 147
        echo $this->getAttribute(($context["nonces"] ?? null), "update_base", []);
    }

    public function getTemplateName()
    {
        return "store-urls.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  315 => 147,  311 => 146,  305 => 142,  295 => 138,  288 => 134,  284 => 133,  276 => 128,  271 => 125,  266 => 124,  256 => 120,  249 => 116,  245 => 115,  237 => 110,  232 => 107,  228 => 106,  222 => 103,  215 => 99,  211 => 98,  203 => 93,  193 => 86,  186 => 82,  182 => 81,  174 => 76,  164 => 69,  157 => 65,  153 => 64,  145 => 59,  135 => 52,  128 => 48,  124 => 47,  116 => 42,  106 => 35,  99 => 31,  95 => 30,  87 => 25,  78 => 18,  67 => 15,  62 => 14,  58 => 13,  52 => 10,  47 => 8,  39 => 3,  35 => 2,  32 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "store-urls.twig", "D:\\xampp\\htdocs\\ecommerce\\wp-content\\plugins\\woocommerce-multilingual\\templates\\store-urls\\store-urls.twig");
    }
}
