<?php

function bot_parse($json) {
    $text = '';
    $tab = json_decode($json);
    if (property_exists($tab, 'output')) {
        $tab = $tab->output;
        if (property_exists($tab, 'generic')) {
            $tab = $tab->generic;
            if (is_array($tab)) {
                foreach ($tab as $item) {
                    if (property_exists($item, 'text')) {
                        $text .= $item->text . '<br>';
                    }
                }
            }
        }
    }
    return $text;
}

function ws_parse($json) {
    $tab = json_decode($json);
    if (property_exists($tab, 'images')) { //[0]->classifiers[0]->classes
        $tab = $tab->images;
        if (is_array($tab)) {
            $tab = $tab[0];
            if (property_exists($tab, 'classifiers')) {
                $tab = $tab->classifiers;
                if (is_array($tab)) {
                    if (property_exists($tab[0], 'classes')) {
                        return $tab[0]->classes;
                    }
                }
            }
        }
    }
    return null;
}

function tas_parse($json) {
    $result = [
        'doc' => [],
        'sentences' => [],
    ];
    $tab = json_decode($json);
    $doc_tones = $tab->document_tone->tones;
    $sentenses = $tab->sentences_tone;
    $result = [
        'doc' => $doc_tones,
        'sentences' => $sentenses,
    ];
    return $result;
}

function number_percent($val) {
    return number_format($val * 100, 2) . '%';
}
