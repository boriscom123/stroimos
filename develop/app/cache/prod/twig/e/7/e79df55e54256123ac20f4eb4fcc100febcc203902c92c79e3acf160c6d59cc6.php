<?php

/* :Form:re_captcha.html.twig */
class __TwigTemplate_e79df55e54256123ac20f4eb4fcc100febcc203902c92c79e3acf160c6d59cc6 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            're_captcha_row' => array($this, 'block_re_captcha_row'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('re_captcha_row', $context, $blocks);
    }

    public function block_re_captcha_row($context, array $blocks = array())
    {
        // line 2
        echo "    <script
        src=\"https://captcha-api.yandex.ru/captcha.js?render=onload&onload=smartCaptchaInit\"
        defer
    ></script>

    <script>
        function callback(token) {
            console.log(token);
            if (token) {
                document
                    .getElementById('error_report_save')
                    .removeAttribute('disabled');
            } else {
                document
                    .getElementById('error_report_save')
                    .setAttribute('disabled', '1');
            }
        }

        function smartCaptchaInit() {
            if (!window.smartCaptcha) {
                return;
            }

            window.smartCaptcha.render('captcha-container', {
                sitekey: '";
        // line 27
        echo twig_escape_filter($this->env, (isset($context["yandex_captcha_site_key"]) ? $context["yandex_captcha_site_key"] : null), "html", null, true);
        echo "',
                callback: callback,
            });
        }

        function smartCaptchaReset() {
            if (!window.smartCaptcha) {
                return;
            }

            window.smartCaptcha.reset();
        }

        function smartCaptchaGetResponse() {
            if (!window.smartCaptcha) {
                return;
            }

            var resp = window.smartCaptcha.getResponse();
            console.log(resp);
            alert(resp);
        }
    </script>

    <div id=\"captcha-container\" style=\"margin-left: 68%;\"></div>";
    }

    public function getTemplateName()
    {
        return ":Form:re_captcha.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  53 => 27,  26 => 2,  20 => 1,);
    }
}
