<?php

function role() {
    if (auth()->user()->role == 1){
        return true;
    } else {
        return false;
    }
}
