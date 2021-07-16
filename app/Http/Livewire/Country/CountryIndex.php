<?php

namespace App\Http\Livewire\Country;

use App\Models\Country;
use Livewire\Component;

class CountryIndex extends Component
{
    public $search = '';
    public $countryCode , $name;
    public $editMode = false;

    
    
    
    public function showEditModal($id)
    {
        
    }

    public function storeCountry()
    {
        # code...
    }

    public function updateCountry()
    {
        # code...
    }

    public function deleteCountry($id)
    {
        
    }

    public function showCountryModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal',['modalId' => '#countryModal', 'actionModal' => 'show'] );
    }

    public function closeModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal',['modalId' => '#countryModal', 'actionModal' => 'hide'] );

    }
    
    
    public function render()
    {
        return view('livewire.country.country-index', [
            'countries' => Country::all()
        ])->layout('layouts.main');
    }
}
