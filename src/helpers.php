<?php

if (! function_exists('getMegaphoneTypes')) {
    function getMegaphoneTypes(): array
    {
        return array_merge(
            (array) config('megaphone.types', []),
            array_keys((array) config('megaphone.customTypes', []))
        );
    }
}

if (! function_exists('getMegaphoneAdminTypes')) {
    function getMegaphoneAdminTypes(): array
    {
        $adminList = config('megaphone.adminTypeList');

        if (is_array($adminList)) {
            return $adminList;
        }

        return getMegaphoneTypes();
    }
}
