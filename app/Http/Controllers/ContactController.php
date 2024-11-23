<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::latest()->paginate(5);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('admin.contacts.create');
    }

    public function store(ContactRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('contact-attachments', 'public');
        }

        Contact::create($data);

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact message sent successfully!');
    }

    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }

    public function edit(Contact $contact)
    {
        return view('admin.contacts.edit', compact('contact'));
    }

    public function update(ContactRequest $request, Contact $contact)
    {
        $data = $request->validated();

        if ($request->hasFile('attachment')) {
            Storage::disk('public')->delete($contact->attachment);
            $data['attachment'] = $request->file('attachment')->store('contact-attachments', 'public');
        }

        $contact->update($data);

        return redirect()->route('contacts.index')
            ->with('success', 'Contact updated successfully!');
    }

    public function destroy(Contact $contact)
    {
        if ($contact->attachment) {
            Storage::disk('public')->delete($contact->attachment);
        }

        $contact->delete();

        return redirect()->route('contacts.index')
            ->with('success', 'Contact deleted successfully!');
    }
}
