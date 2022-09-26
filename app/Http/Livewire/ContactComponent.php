<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Mail\ContactForm;
use Illuminate\Support\Facades\Mail;

class ContactComponent extends Component
{
    public $name, $email, $phone, $subject, $message;
    public $success;

    //Validacion en tiempo real
    protected $rules = [
        'name' => 'required',
        'email' => 'required',
        'phone' => 'required',
        'subject' => 'required',
        'message' => 'required'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        //Se valida las
        $rules = $this->validate();

        $data['name'] = $this->name;
        $data['email'] = $this->email;
        $data['phone'] = $this->phone;
        $data['subject'] = $this->subject;
        $data['message'] = $this->message;

        //Se instancia ContactForm y se envian los datos del formulario
        Mail::to('info@diarioprogramador.com')->send(new ContactForm($data));

        //Se llama a la funcion resetForm()
        $this->resetForm();

        //se envia mensaje de exito a la vista
        $this->success = 'Mensaje enviado con éxito';
    }

    //metodo limpia los campos del formulario
    private function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->subject = '';
        $this->message = '';
    }

    public function render()
    {
        return view('livewire.contact-component');
    }
}
