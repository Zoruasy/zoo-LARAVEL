<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AnimalItem extends Component
{
    public $name;
    public $species;
    public $habitat;

    public function __construct($name, $species, $habitat)
    {
        $this->name = $name;
        $this->species = $species;
        $this->habitat = $habitat;
    }

    public function render()
    {
        return view('components.animal-item');
    }
}



?>
