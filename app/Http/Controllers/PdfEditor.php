<?php

namespace App\Http\Controllers;

use mikehaertl\pdftk\Pdf;

class PdfEditor extends Controller
 {
 /**
 * Show the application dashboard.
 *
 * @return \Illuminate\Http\Response
 */
 public function index()
 {
 return view('pdftest.upload');
 }

public function store(Request $request)
 {
 $uploadedFile = $request->file('pdf_file');
 $filename = $uploadedFile->getClientOriginalName();

$request->session()->put('current_pdf', $filename);

Storage::disk('local')->putFileAs(
 'files/'.$filename,
 $uploadedFile,
 $filename
 );

return redirect()->back()->with('success', 'Your file is submitted Successfully');
 }

public function preview()
 {
 if(Session::has('current_pdf')) {
 $filepath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . 'files/'. Session::get('current_pdf');
 $filename = $filepath . '/' . Session::get('current_pdf');

return response(file_get_contents($filename))->withHeaders([
 'Content-Type' => 'application/pdf'
 ]);
 }
 return redirect()->back()->with('error', 'Sorry. File not found.');
 }

public function edit()
 {
 $filepath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . 'files/'. Session::get('current_pdf');
 $filename = $filepath . '/' . Session::get('current_pdf');
 $pdf = new Pdf($filename);

$fields = $pdf->getDataFields(true)->__toArray();

return view('pdftest.edit')->with('fields',$fields);
 }

public function save(Request $request)
 {
 $filepath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . 'files/'. Session::get('current_pdf');
 $filename = $filepath . '/' . Session::get('current_pdf');
 $target = $filepath . '/filled_' . Session::get('current_pdf');
 $pdf = new Pdf($filename);

$inputs = $request->all();
 unset($inputs['_token']);
 foreach ($inputs as $field=>$value) {
 $data[str_replace('_',' ',$field)] = $value;
 }

$pdf->fillForm($data)
 ->needAppearances();

if (!$pdf->saveAs($target)) {
 $error = $pdf->getError();
 dd($error);
 }
 return response(file_get_contents($target))->withHeaders([
 'Content-Type' => 'application/pdf'
 ]);
 }
 }