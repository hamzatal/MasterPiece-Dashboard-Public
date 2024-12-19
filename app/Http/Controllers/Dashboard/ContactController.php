<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query();

        // Search functionality
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('subject', 'like', "%{$request->search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Priority filter
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Sorting
        if ($request->filled('sort')) {
            $query->orderBy(
                $request->sort,
                $request->direction ?? 'desc'
            );
        } else {
            $query->latest();
        }

        $contacts = $query->paginate(10);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('admin.contacts.create');
    }

    public function store(ContactRequest $request)
    {
        try {
            $data = $request->validated();

            // Handle file upload
            if ($request->hasFile('attachment')) {
                $data['attachment'] = $request->file('attachment')->store('contact-attachments', 'public');
            }

            // Set default status if not provided
            $data['status'] = $data['status'] ?? 'new';
            $data['priority'] = $data['priority'] ?? 'medium';

            $contact = Contact::create($data);

            return redirect()->route('admin.contacts.index')
                ->with('success', 'Contact message sent successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to create contact. Please try again.');
        }
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
        try {
            $data = $request->validated();

            // Handle file upload and deletion
            if ($request->hasFile('attachment')) {
                // Delete old attachment if exists
                if ($contact->attachment) {
                    Storage::disk('public')->delete($contact->attachment);
                }

                // Store new attachment
                $data['attachment'] = $request->file('attachment')->store('contact-attachments', 'public');
            }

            $contact->update($data);

            return redirect()->route('admin.contacts.index')
                ->with('success', 'Contact updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to update contact. Please try again.');
        }
    }

    public function destroy(Contact $contact)
    {
        try {
            // Delete attachment if exists
            if ($contact->attachment) {
                Storage::disk('public')->delete($contact->attachment);
            }

            $contact->delete();

            return redirect()->route('admin.contacts.index')
                ->with('success', 'Contact deleted successfully!');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to delete contact. Please try again.');
        }
    }
}
