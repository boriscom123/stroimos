<?php

/* ::/layout/counters.html.twig */
class __TwigTemplate_42685f8da1a3d4036ab85094209de719dc533d0599281b10fd94b4a229226727 extends Twig_Template
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
        $context["host"] = $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "server", array()), "get", array(0 => "HTTP_HOST"), "method");
        // line 2
        if (twig_test_empty((isset($context["host"]) ? $context["host"] : null))) {
            // line 3
            $context["host"] = $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "server", array()), "get", array(0 => "SERVER_NAME"), "method");
        }
        // line 6
        if ((twig_lower_filter($this->env, (isset($context["host"]) ? $context["host"] : null)) == "stroi.mos.ru")) {
            // line 9
            echo "    <!-- Yandex.Metrika informer --><script type=\"text/javascript\"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter20919760 = new Ya.Metrika({ id:20919760, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, params:window.yaParams||{ } }); } catch(e) { } }); var n = d.getElementsByTagName(\"script\")[0], s = d.createElement(\"script\"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = \"text/javascript\"; s.async = true; s.src = \"https://mc.yandex.ru/metrika/watch.js\"; if (w.opera == \"[object Opera]\") { d.addEventListener(\"DOMContentLoaded\", f, false); } else { f(); } })(document, window, \"yandex_metrika_callbacks\");</script><noscript><div><img src=\"https://mc.yandex.ru/watch/20919760\" style=\"position:absolute; left:-9999px;\" alt=\"\" /></div></noscript><!-- /Yandex.Metrika counter -->
    <!-- Yandex.Metrika counter --><script type=\"text/javascript\">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter14112952 = new Ya.Metrika({id:14112952, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true, ut:\"noindex\"}); } catch(e) { } }); var n = d.getElementsByTagName(\"script\")[0], s = d.createElement(\"script\"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = \"text/javascript\"; s.async = true; s.src = (d.location.protocol == \"https:\" ? \"https:\" : \"http:\") + \"//mc.yandex.ru/metrika/watch.js\"; if (w.opera == \"[object Opera]\") { d.addEventListener(\"DOMContentLoaded\", f, false); } else { f(); } })(document, window, \"yandex_metrika_callbacks\");</script><noscript><div><img src=\"//mc.yandex.ru/watch/14112952?ut=noindex\" style=\"position:absolute; left:-9999px;\" alt=\"\" /></div></noscript><!-- /Yandex.Metrika counter -->";
        } else {
            // line 16
            echo "    <!-- Yandex.Metrika counter -->
    <script type=\"text/javascript\">
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter33010414 = new Ya.Metrika({
                        id:33010414,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true
                    });
                } catch(e) { }
            });

            var n = d.getElementsByTagName(\"script\")[0],
                    s = d.createElement(\"script\"),
                    f = function () { n.parentNode.insertBefore(s, n); };
            s.type = \"text/javascript\";
            s.async = true;
            s.src = \"https://mc.yandex.ru/metrika/watch.js\";

            if (w.opera == \"[object Opera]\") {
                d.addEventListener(\"DOMContentLoaded\", f, false);
            } else { f(); }
        })(document, window, \"yandex_metrika_callbacks\");
    </script>
    <noscript><div><img src=\"https://mc.yandex.ru/watch/33010414\" style=\"position:absolute; left:-9999px;\" alt=\"\" /></div></noscript>
    <!-- /Yandex.Metrika counter -->";
        }
    }

    public function getTemplateName()
    {
        return "::/layout/counters.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  32 => 16,  28 => 9,  26 => 6,  23 => 3,  21 => 2,  19 => 1,);
    }
}
