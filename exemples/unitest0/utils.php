<?php
function p(string $content)
{

    return $content == '' ? '' : '<p>' . $content . '</p>';
}

/*echo p('hello');
echo p('');
echo p(1);
echo p(['toto']);
echo p(null);*/