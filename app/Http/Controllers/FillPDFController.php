<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;
use App\Http\Controllers\ImageUploadController;

class FillPDFController extends ImageUploadController
{
    public function process(Request $request)
    {
        // download sample file.
        Storage::disk('local')->put('test.pdf', file_get_contents('https://contracts-lawyers.s3.us-east-1.amazonaws.com/Lease.pdf?response-content-disposition=inline&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEMH%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEaCmFwLXNvdXRoLTEiRzBFAiAwU8pDkM38gs66dGK1pvJ1Sym0fSabou1WUDK6AUGHBAIhAIukVrlVkNP%2B%2FjKBhv4U9IthIR7%2Ft1aOLAZpBDJ3rzQtKvECCPr%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEQAhoMNDc2NzM4NjUzOTA4IgxehwA%2FIEe0bU90idEqxQJd6EHvxCtXnCViCcB4iE3sq0S5Vh9uu0NhaffU1ujhnyC8yJfSfBj8j3CZ2ltjfXMoWlfx6Fh0TnwZTI2tDGB6OloQ2PHJ2X%2FcrBk9vk7HMlEfQeIUyCldeG1CkVy3MoKTx6mxYdWzjPe%2FkQ7Uyjl1memPQ%2B7FaiRSoKJ5y4Y9tCZ1Vuyzub3tDuWqjjtPwWGzaKH3f9yKQP%2FhqA3TimGCZqdYo%2B%2Bf4JCtbWneABlx8p4fuyWM%2BtDFfdbEBQUa57XVhyU8xqs%2Fym7K5tPeckCiA7Ovkyurd1Y4v%2Fk4TZYWj9PQwBPWDRrYVXuGLa%2FgLvoaqc4x2lcmLdeuxnCRvqVHjNONtUyiQkxQ012Fy9YSgYbM6mDI%2Bni6fSFqCsIr%2BsCrQXBZT43vI89FA7jhFjrAEAtQISxaZz%2BODlRdfqgVAxucbk9XMJTpo50GOrMCIOglQ69Z0W0Rurrjudfdg4ZDEZxjcmkM%2BjRzs8LymFxEML29wJbjwMExg60ObeJnQLzdVYPvMvAbYA97gctq4%2BEVCddcjf5o%2FamlFluZWJQ2MlUZsfqqzwr2FBRZtPPVj%2BPM7BSbl2%2BNw5H%2B066dGQ0TgkhaO7dUAqaV%2F1MjyqSJPSNbbTvuCHCdT%2FwBGdRbcw3R4WqhWWM6bQ%2F38dg7l4uGOLiLcSfioRGrN8mOKi2cYhUKllNDqzSGAQ2u%2BLii5t%2FlSrQDY16IcFi%2FPyu1WQWSVA4S3IpWGULSBQPKRWIcu3c6EZUXO5WOWyaDxRS3Ix0uMKnkJA98Ogy8CiXxpcM1Kq9jThITXSE0iwgd1vvs48EtwVjNd6EjdLyFHRL2wtm7cZryEbU%2F9Y58IumO8XFfMg%3D%3D&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Date=20221226T020325Z&X-Amz-SignedHeaders=host&X-Amz-Expires=300&X-Amz-Credential=ASIAW576WR3KEA3T3NIF%2F20221226%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Signature=30ce981ad4eed718edde15ed93e87b94fce2d34a05d007eb0f4ae9ae61350d68'));

        $outputFile = Storage::disk('local')->path('output.pdf');
        // fill data
        $this->fillPDF(Storage::disk('local')->path('test.pdf'), $outputFile);
        //output to browser
        #upload to s3
        pdfUploadPost(['image'=>$outputFile]);
        #get url for download
        #fill url variable

        $url = "https://contracts-lawyers.s3.us-east-1.amazonaws.com/Lease.pdf?response-content-disposition=inline&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEEAaCmFwLXNvdXRoLTEiRzBFAiEAqBtea4VRgUhwcOpi9Xb494jXIXzl8mRs1TXMEmctFYgCICkskNjDct66CHFsjP5NZSf4Syoh27KFtw96uuyv4AqeKugCCHoQAhoMNDc2NzM4NjUzOTA4Igw4qIf5aX2CypeFEmMqxQJEzHnr81lszq9RLBQvEd1oV7xfV5L9z5ea8A%2BIWUkYTN0Zx%2FtDU3MDV4zNAVgZ2m52xuHYOQU0GmR9%2Fe9v3L1Fgww7jgU2dh3p96cpdQUsH4dhO3IrL3FcU20PbUQvulSKP8IyYDYAlOGhVWtUqPwSPixVuhzVVR2xuNY%2B%2B2QvtHrUr1uonYpQUJJ%2BuoIWpiUaChn%2BXAk%2F6EuKcpxY38%2FBrJexGG3IQxM%2BIE%2BvBQOqCjJdjwTYSiZ%2BN9VmhPVv5wJ83qyBviHlYv2OTjv2FcpRWDFoGlzktEDm3aCRvS7HNA1ldul7iYyqesmVyDrtq%2BjWhjmBiw3Ul3K2W6lJE3EMG8OPGdEdbzSBNQYMwebdW5ZoZcTVE7mSquFWP1Ghqt8dW82l69xDn%2Fm7VA6Yau7m907I5Auzr8X0Fy%2BHdcvoufityhVhMIHGh50GOrMColwkbe3zgrsJjF05ffjZ0rRjAqOWsph%2F%2FpgrzRYfcKheer8s7rSDpllj964TLgL9QOm9E962BUcJHM4z9mzZn7OQ79KBjZui4fNmCXP6B2kD%2BCqj%2Faw1PbfPVtt6NQhTnwXmOhLw5p8163Cx8gv%2FZaZ4zyK%2Ba9nkxJXZswiuq8fE3PIbCUipASCPtUdE7Gud44ar2p0FVkhVrIvvFVTn%2FvLFvbo5TZXZYB5CTHL6AhEO4dA6j03jLWJyYHtx5uyVSHM2aYLblwHY%2Fsb1oR5CPjL6SAQJt2QpeyFfIE%2FU4P2%2BXJQyGHrZsfUxfRUEL%2BUFxCO5%2FYOFKsESAjqLB43o9qgp%2BjuxRMSWc6mW1WyzSj2DssEP41cz7W5qi638j0eJh5U%2B6Cgk%2FdQCxGVzLzJMoKaQHQ%3D%3D&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Date=20221220T163858Z&X-Amz-SignedHeaders=host&X-Amz-Expires=43200&X-Amz-Credential=ASIAW576WR3KBOGMFCMI%2F20221220%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Signature=3fa3f59c6a543902128c1738e5fa5da7b213f04ecda87bdc2ab69988a1caf65c";
        return response()->json([
            'url' => $url,
            'status' => 200,
        ]);
        #response()->file($outputFile);
    }

    public function fillPDF($file, $outputFile)
    {
        $fpdi = new FPDI;
        // merger operations
        $count = $fpdi->setSourceFile($file);
        for ($i=1; $i<=$count; $i++) {
            $template   = $fpdi->importPage($i);
            $size       = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);
            $fpdi->SetFont("helvetica", "", 11);
            $fpdi->SetTextColor(0,0,0);
            $fpdi->Text(55,101,"Ali AlQattan");
            $fpdi->Text(55,106,"Ali AlQattan123");
        }
        return $fpdi->Output($outputFile, 'F');
    }
}