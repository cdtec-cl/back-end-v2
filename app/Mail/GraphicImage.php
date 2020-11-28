<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GraphicImage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $svgFormat;
    public $eventDate;
    public $eventTime;
    public $comment;
    public $routeFile;
    public function __construct($svgFormat,$eventDate,$eventTime,$comment,$routeFile)
    {
        $this->svgFormat=$svgFormat;
        $this->eventDate=$eventDate;
        $this->eventTime=$eventTime;
        $this->comment=$comment;
        $this->routeFile=$routeFile;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.graphic-image')
            ->subject('Imagen de gráfica')
            ->attach($this->routeFile);
    }
}
