<?php 

namespace App\Services;

use App\Http\Requests\CreateLinkRequest;
use App\Models\Link;
use Hidehalo\Nanoid\Client;
use Hidehalo\Nanoid\GeneratorInterface;

class ShortLinkCreator
{
    protected CreateLinkRequest $createLinkRequest;
    private $codeLength;

    public function __construct()
    {
        $this->codeLength = config('services.code.length');
    }

    public function createNewLink(CreateLinkRequest $createLinkRequest) : Link
    {
        $link = new Link();
        $link->original_url = $createLinkRequest->get('original_url');
        $link->clicks_limit = $createLinkRequest->get('clicks_limit');
        $link->short_code = $this->generateCode();
        $link->expired_at = $createLinkRequest->get('expired_at');
        $link->save();

        return $link;
    }

    private function generateCode() : string
    {
        return (new Client())->generateId($size = $this->codeLength, 
                                          $mode = Client::MODE_DYNAMIC);
    }
}