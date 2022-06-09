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

/* products.twig */
class __TwigTemplate_b98c825d62baf128ea7e48605cee9057eb6f03cb0ee8ac1ef94f197d7eafc1e9 extends \WPML\Core\Twig\Template
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
        echo "<form method=\"post\" action=\"";
        echo \WPML\Core\twig_escape_filter($this->env, ($context["request_uri"] ?? null));
        echo "\">

\t";
        // line 3
        echo ($context["auto_translate_container"] ?? null);
        echo "

\t";
        // line 5
        $this->loadTemplate("filter.twig", "products.twig", 5)->display(twig_array_merge($context, ($context["filter"] ?? null)));
        // line 6
        echo "
\t<table class=\"widefat fixed wpml-list-table wp-list-table striped\" cellspacing=\"0\">
\t\t<thead>
\t\t\t<tr>
\t\t\t\t<th scope=\"col\" class=\"column-thumb\">
\t\t\t\t\t\t<span class=\"wc-image wcml-tip\"
\t\t\t\t\t\t\t  data-tip=\"";
        // line 12
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "image", []));
        echo "\">";
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "image", []), "html", null, true);
        echo "</span>
\t\t\t\t</th>
\t\t\t\t<th scope=\"col\" class=\"wpml-col-title ";
        // line 14
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["filter_urls"] ?? null), "product_sorted", []), "html", null, true);
        echo "\">
\t\t\t\t\t<a href=\"";
        // line 15
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["filter_urls"] ?? null), "product", []));
        echo "\">
\t\t\t\t\t\t<span>";
        // line 16
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "product", []), "html", null, true);
        echo "</span>
\t\t\t\t\t\t<span class=\"sorting-indicator\"></span>
\t\t\t\t\t</a>
\t\t\t\t</th>
\t\t\t\t<th scope=\"col\" class=\"wpml-col-languages\">
\t\t\t\t\t";
        // line 21
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["languages_flags"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["language"]) {
            // line 22
            echo "\t\t\t\t\t\t<span title=\"";
            echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["language"], "name", []));
            echo "\">
\t\t\t\t\t\t\t<img src=\"";
            // line 23
            echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["language"], "flag_url", []), "html", null, true);
            echo "\"  alt=\"";
            echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["language"], "name", []));
            echo "\"/>
\t\t\t\t\t\t</span>
\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['language'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 26
        echo "\t\t\t\t</th>
\t\t\t\t<th scope=\"col\"
\t\t\t\t\tclass=\"column-categories\">";
        // line 28
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "categories", []), "html", null, true);
        echo "</th>
\t\t\t\t";
        // line 29
        if ($this->getAttribute(($context["strings"] ?? null), "type", [])) {
            // line 30
            echo "\t\t\t\t\t<th scope=\"col\" class=\"column-product_type\">
\t\t\t\t\t\t\t<span class=\"wc-type wcml-tip\"
\t\t\t\t\t\t\t\t  data-tip=\"";
            // line 32
            echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "type", []));
            echo "\">";
            echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "type", []), "html", null, true);
            echo "</span>
\t\t\t\t\t</th>
\t\t\t\t";
        }
        // line 35
        echo "\t\t\t\t<th scope=\"col\" id=\"date\" class=\"column-date ";
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["filter_urls"] ?? null), "date_sorted", []), "html", null, true);
        echo "\">
\t\t\t\t\t<a href=\"";
        // line 36
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["filter_urls"] ?? null), "date", []));
        echo "\">
\t\t\t\t\t\t<span>";
        // line 37
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "date", []), "html", null, true);
        echo "</span>
\t\t\t\t\t\t<span class=\"sorting-indicator\"></span>
\t\t\t\t\t</a>
\t\t\t\t</th>
\t\t\t</tr>
\t\t</thead>

\t\t<tbody>
\t\t\t";
        // line 45
        if (twig_test_empty($this->getAttribute(($context["data"] ?? null), "products", []))) {
            // line 46
            echo "\t\t\t\t<tr>
\t\t\t\t\t<td colspan=\"6\" class=\"text-center\">
\t\t\t\t\t\t<strong>";
            // line 48
            echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "no_products", []), "html", null, true);
            echo "</strong>
\t\t\t\t\t</td>
\t\t\t\t</tr>
\t\t\t";
        } else {
            // line 52
            echo "\t\t\t\t";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["data"] ?? null), "products", []));
            foreach ($context['_seq'] as $context["_key"] => $context["product"]) {
                // line 53
                echo "\t\t\t\t\t<tr>
\t\t\t\t\t\t<td class=\"thumb column-thumb\">
\t\t\t\t\t\t\t<a href=\"";
                // line 55
                echo $this->getAttribute($context["product"], "edit_post_link", []);
                echo "\">
\t\t\t\t\t\t\t\t<img width=\"150\" height=\"150\" src=\"";
                // line 56
                echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["product"], "post_thumbnail", []), "html", null, true);
                echo "\" class=\"wp-post-image original-image\" data-image-id=\"thumbnail-";
                echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["product"], "ID", []), "html", null, true);
                echo "\" >
\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t</td>

\t\t\t\t\t\t";
                // line 61
                echo "\t\t\t\t\t\t";
                if ($this->getAttribute($context["product"], "has_image", [])) {
                    // line 62
                    echo "\t\t\t\t\t\t\t<img id=\"thumbnail-";
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["product"], "ID", []), "html", null, true);
                    echo "\" src=\"";
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["product"], "post_thumbnail", []), "html", null, true);
                    echo "\" class=\"mouse-hovered\">
\t\t\t\t\t\t";
                }
                // line 64
                echo "
\t\t\t\t\t\t<td class=\"wpml-col-title  wpml-col-title-flag\">
\t\t\t\t\t\t\t";
                // line 66
                if (($this->getAttribute($context["product"], "post_parent", []) != 0)) {
                    echo " &#8212; ";
                }
                // line 67
                echo "\t\t\t\t\t\t\t<strong>
\t\t\t\t\t\t\t\t";
                // line 68
                if ( !$this->getAttribute(($context["data"] ?? null), "slang", [])) {
                    // line 69
                    echo "\t\t\t\t\t\t\t\t\t<span class=\"wpml-title-flag\">
\t\t\t\t\t\t\t\t\t\t<img src=\"";
                    // line 70
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["product"], "orig_flag_url", []), "html", null, true);
                    echo "\"/>
\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t";
                }
                // line 73
                echo "
\t\t\t\t\t\t\t\t<a href=\"";
                // line 74
                echo $this->getAttribute($context["product"], "edit_post_link", []);
                echo "\" title=\"";
                echo \WPML\Core\twig_escape_filter($this->env, strip_tags($this->getAttribute($context["product"], "post_title", [])), "html", null, true);
                echo "\">
\t\t\t\t\t\t\t\t\t";
                // line 75
                echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["product"], "post_title", []), "html", null, true);
                echo "
\t\t\t\t\t\t\t\t</a>

\t\t\t\t\t\t\t\t";
                // line 78
                if (($this->getAttribute($context["product"], "post_status", []) == "draft")) {
                    // line 79
                    echo "\t\t\t\t\t\t\t\t\t- <span class=\"post-state\">";
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "draft", []), "html", null, true);
                    echo "</span>
\t\t\t\t\t\t\t\t";
                }
                // line 81
                echo "
\t\t\t\t\t\t\t\t";
                // line 82
                if (($this->getAttribute($context["product"], "post_status", []) == "private")) {
                    // line 83
                    echo "\t\t\t\t\t\t\t\t\t- <span class=\"post-state\">";
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "private", []), "html", null, true);
                    echo "</span>
\t\t\t\t\t\t\t\t";
                }
                // line 85
                echo "
\t\t\t\t\t\t\t\t";
                // line 86
                if (($this->getAttribute($context["product"], "post_status", []) == "pending")) {
                    // line 87
                    echo "\t\t\t\t\t\t\t\t\t- <span class=\"post-state\">";
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "pending", []), "html", null, true);
                    echo "</span>
\t\t\t\t\t\t\t\t";
                }
                // line 89
                echo "
\t\t\t\t\t\t\t\t";
                // line 90
                if (($this->getAttribute($context["product"], "post_status", []) == "future")) {
                    // line 91
                    echo "\t\t\t\t\t\t\t\t\t- <span class=\"post-state\">";
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "future", []), "html", null, true);
                    echo "</span>
\t\t\t\t\t\t\t\t";
                }
                // line 93
                echo "
\t\t\t\t\t\t\t\t";
                // line 94
                if (($this->getAttribute(($context["data"] ?? null), "search", []) && ($this->getAttribute($context["product"], "post_parent", []) != 0))) {
                    // line 95
                    echo "\t\t\t\t\t\t\t\t\t| <span class=\"prod_parent_text\">
\t\t\t\t\t\t\t\t\t\t";
                    // line 96
                    echo \WPML\Core\twig_escape_filter($this->env, sprintf($this->getAttribute(($context["strings"] ?? null), "parent", []), $this->getAttribute($context["product"], "parent_title", [])), "html", null, true);
                    echo "
\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t";
                }
                // line 99
                echo "\t\t\t\t\t\t\t</strong>

\t\t\t\t\t\t\t<div class=\"row-actions\">
\t\t\t\t\t\t\t\t<span class=\"edit\">
\t\t\t\t\t\t\t\t\t<a href=\"";
                // line 103
                echo $this->getAttribute($context["product"], "edit_post_link", []);
                echo "\"
\t\t\t\t\t\t\t\t\t   title=\"";
                // line 104
                echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "edit_item", []));
                echo "\">";
                echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "edit", []), "html", null, true);
                echo "</a>
\t\t\t\t\t\t\t\t</span> | <span class=\"view\">
\t\t\t\t\t\t\t\t\t<a href=\"";
                // line 106
                echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["product"], "view_link", []));
                echo "\"
\t\t\t\t\t\t\t\t\t   title=\"";
                // line 107
                echo \WPML\Core\twig_escape_filter($this->env, sprintf($this->getAttribute(($context["strings"] ?? null), "view_link", []), $this->getAttribute($context["product"], "post_title", [])));
                echo "\" target=\"_blank\">";
                echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "view", []), "html", null, true);
                echo "</a>
\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t</td>

\t\t\t\t\t\t<td class=\"wpml-col-languages\">
\t\t\t\t\t\t\t";
                // line 114
                echo $this->getAttribute($context["product"], "translation_statuses", []);
                echo "
\t\t\t\t\t\t</td>
\t\t\t\t\t\t<td class=\"column-categories\">
\t\t\t\t\t\t\t";
                // line 117
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["product"], "categories_list", []));
                foreach ($context['_seq'] as $context["_key"] => $context["category"]) {
                    // line 118
                    echo "\t\t\t\t\t\t\t\t<a href=\"";
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["category"], "href", []));
                    echo "\">";
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["category"], "name", []), "html", null, true);
                    echo "</a>
\t\t\t\t\t\t\t";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['category'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 120
                echo "\t\t\t\t\t\t</td>
\t\t\t\t\t\t";
                // line 121
                if ($this->getAttribute(($context["strings"] ?? null), "type", [])) {
                    // line 122
                    echo "\t\t\t\t\t\t\t<td class=\"column-product_type\">
\t\t\t\t\t\t\t\t<span class=\"product-type wcml-tip ";
                    // line 123
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["product"], "icon_class", []));
                    echo "\"
\t\t\t\t\t\t\t\t\t  data-tip=\"";
                    // line 124
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["product"], "icon_class", []));
                    echo "\"></span>
\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t";
                }
                // line 127
                echo "
\t\t\t\t\t\t<td class=\"column-date\">
\t\t\t\t\t\t\t";
                // line 129
                echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["product"], "formated_date", []), "html", null, true);
                echo "

\t\t\t\t\t\t\t";
                // line 131
                if (($this->getAttribute($context["product"], "post_status", []) == "publish")) {
                    // line 132
                    echo "\t\t\t\t\t\t\t\t<br>";
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "published", []), "html", null, true);
                    echo "
\t\t\t\t\t\t\t";
                } else {
                    // line 134
                    echo "\t\t\t\t\t\t\t\t<br>";
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "modified", []), "html", null, true);
                    echo "
\t\t\t\t\t\t\t";
                }
                // line 136
                echo "\t\t\t\t\t\t</td>
\t\t\t\t\t</tr>
\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['product'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 139
            echo "\t\t\t";
        }
        // line 140
        echo "\t\t</tbody>
\t</table>

\t<input type=\"hidden\" id=\"upd_product_nonce\" value=\"";
        // line 143
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["nonces"] ?? null), "upd_product", []));
        echo "\" />
\t<input type=\"hidden\" id=\"get_product_data_nonce\" value=\"";
        // line 144
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["nonces"] ?? null), "get_product_data", []));
        echo "\" />

\t";
        // line 146
        $this->loadTemplate("pagination.twig", "products.twig", 146)->display(twig_array_merge($context, ($context["pagination"] ?? null)));
        // line 147
        echo "</form>";
    }

    public function getTemplateName()
    {
        return "products.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  398 => 147,  396 => 146,  391 => 144,  387 => 143,  382 => 140,  379 => 139,  371 => 136,  365 => 134,  359 => 132,  357 => 131,  352 => 129,  348 => 127,  342 => 124,  338 => 123,  335 => 122,  333 => 121,  330 => 120,  319 => 118,  315 => 117,  309 => 114,  297 => 107,  293 => 106,  286 => 104,  282 => 103,  276 => 99,  270 => 96,  267 => 95,  265 => 94,  262 => 93,  256 => 91,  254 => 90,  251 => 89,  245 => 87,  243 => 86,  240 => 85,  234 => 83,  232 => 82,  229 => 81,  223 => 79,  221 => 78,  215 => 75,  209 => 74,  206 => 73,  200 => 70,  197 => 69,  195 => 68,  192 => 67,  188 => 66,  184 => 64,  176 => 62,  173 => 61,  164 => 56,  160 => 55,  156 => 53,  151 => 52,  144 => 48,  140 => 46,  138 => 45,  127 => 37,  123 => 36,  118 => 35,  110 => 32,  106 => 30,  104 => 29,  100 => 28,  96 => 26,  85 => 23,  80 => 22,  76 => 21,  68 => 16,  64 => 15,  60 => 14,  53 => 12,  45 => 6,  43 => 5,  38 => 3,  32 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "products.twig", "D:\\xampp\\htdocs\\ecommerce\\wp-content\\plugins\\woocommerce-multilingual\\templates\\products-list\\products.twig");
    }
}
