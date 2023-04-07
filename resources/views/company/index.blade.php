<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Company') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
            
                    <table class="min-w-full text-left text-sm font-light">
                        <thead class="border-b bg-white font-medium dark:border-neutral-500 dark:bg-neutral-600">
                            <tr>
                                <th>S.No</th>
                                <th>Company Name</th>
                                <th>Company Email</th>
                                <th>Company Logo</th>
                                <th>Company Website</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($companies as $key => $company)
                                <tr>
                                    <td>{{ ($companies->currentpage()-1) * $companies->perpage() + $key + 1 }}</td>
                                    <td>{{ $company->name }}</td>
                                    <td>{{ $company->email }}</td>
                                    <td><img width="30" height="30" src= "{{ asset('storage/'.$company->logo) }}" /></td>
                                    <td>{{ $company->website }}</td>
                                    <td><a class="btn btn-primary" href="{{ route('company.edit',$company->id) }}">Edit</a></td>
                                    <td>
                                        <form action="{{ route('company.destroy',$company->id) }}" method="Post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                    {!! $companies->links() !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>