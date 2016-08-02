<?php

echo $view->header()->setAttribute('template', $T('Settings_title'));

echo $view->panel()
    ->insert($view->selector('Subnets', $view::SELECTOR_MULTIPLE));

echo $view->buttonList($view::BUTTON_SUBMIT | $view::BUTTON_CANCEL | $view::BUTTON_HELP);

