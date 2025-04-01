<?php

/* ::/Post/description.html.twig */
class __TwigTemplate_485ec7b019a74e2f79a19a8ab247f70adfcbd5429c2a49f777ab4fd1c36ae049 extends Twig_Template
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
        if ((isset($context["description"]) ? $context["description"] : null)) {
            // line 2
            echo "<div class=\"objects-construction container__full\">
    <h3 class=\"objects-construction__title\">Описание</h3>
    <div class=\"objects-construction__legend\">";
            // line 5
            echo (isset($context["description"]) ? $context["description"] : null);
            echo "
    </div>
</div>";
        }
    }

    public function getTemplateName()
    {
        return "::/Post/description.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  25 => 5,  21 => 2,  19 => 1,);
    }
}
