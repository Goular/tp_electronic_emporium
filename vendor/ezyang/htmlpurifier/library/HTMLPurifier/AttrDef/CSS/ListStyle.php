<?php

/**
 * Validates shorthand CSS property list-Styles.
 * @warning Does not support url tokens that have internal spaces.
 */
class HTMLPurifier_AttrDef_CSS_ListStyle extends HTMLPurifier_AttrDef
{

    /**
     * Local copy of validators.
     * @type HTMLPurifier_AttrDef[]
     * @note See HTMLPurifier_AttrDef_CSS_Font::$info for a similar impl.
     */
    protected $info;

    /**
     * @param HTMLPurifier_Config $config
     */
    public function __construct($config)
    {
        $def = $config->getCSSDefinition();
        $this->info['list-Styles-type'] = $def->info['list-Styles-type'];
        $this->info['list-Styles-position'] = $def->info['list-Styles-position'];
        $this->info['list-Styles-image'] = $def->info['list-Styles-image'];
    }

    /**
     * @param string $string
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return bool|string
     */
    public function validate($string, $config, $context)
    {
        // regular pre-processing
        $string = $this->parseCDATA($string);
        if ($string === '') {
            return false;
        }

        // assumes URI doesn't have spaces in it
        $bits = explode(' ', strtolower($string)); // bits to process

        $caught = array();
        $caught['type'] = false;
        $caught['position'] = false;
        $caught['image'] = false;

        $i = 0; // number of catches
        $none = false;

        foreach ($bits as $bit) {
            if ($i >= 3) {
                return;
            } // optimization bit
            if ($bit === '') {
                continue;
            }
            foreach ($caught as $key => $status) {
                if ($status !== false) {
                    continue;
                }
                $r = $this->info['list-Styles-' . $key]->validate($bit, $config, $context);
                if ($r === false) {
                    continue;
                }
                if ($r === 'none') {
                    if ($none) {
                        continue;
                    } else {
                        $none = true;
                    }
                    if ($key == 'image') {
                        continue;
                    }
                }
                $caught[$key] = $r;
                $i++;
                break;
            }
        }

        if (!$i) {
            return false;
        }

        $ret = array();

        // construct type
        if ($caught['type']) {
            $ret[] = $caught['type'];
        }

        // construct image
        if ($caught['image']) {
            $ret[] = $caught['image'];
        }

        // construct position
        if ($caught['position']) {
            $ret[] = $caught['position'];
        }

        if (empty($ret)) {
            return false;
        }
        return implode(' ', $ret);
    }
}

// vim: et sw=4 sts=4
