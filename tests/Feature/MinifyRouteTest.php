<?php

it('registers the minify asset route', function () {
    expect(fn () => route('minify.assets', ['file' => 'css/fontawesome.css']))
        ->not->toThrow();
});
