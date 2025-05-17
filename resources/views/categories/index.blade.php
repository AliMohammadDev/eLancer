   @extends('layouts.dashboard')
   @section('content')
   @section('page-title')
       Categories
       <saml>
           <a href="{{ route('categories.create') }}" class="btn btn-sm  btn-outline-primary">
               Create
           </a>
       </saml>
   @endsection

   {{-- @if ($flashMessage)
       <div class="alert alert-success">
           {{ $flashMessage }}
       </div>
   @endif --}}
   <x-flash-message />

   <table class="table table-striped">
       <thead>
           <tr>
               <th scope="col">ID</th>
               <th scope="col">Name</th>
               <th scope="col">Slug</th>
               <th scope="col">Parent ID</th>
               <th scope="col">Art File</th>
               <th scope="col">Created At</th>

           </tr>
       </thead>
       <tbody>


           @foreach ($categories as $category)
               <tr>
                   <td> {{ $category->id }}</td>
                   <td><a href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a></td>
                   <td> {{ $category->slug }}</td>
                   <td> {{ $category->parent_name }}</td>
                   <td>
                       <img style="width: 70px; height:60px;" src="{{ asset('uploads/'.$category->art_file) }}" alt="">
                   </td>
                   <td> {{ $category->created_at }}</td>
                   <td><a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-dark">Edit</a></td>
                   <td>
                       <form action="{{ route('categories.destroy', $category->id) }}" method="post">
                           {{-- {{ csrf_field() }} --}}
                           @csrf
                           @method('delete')
                           {{-- <input type="hidden" name="_method" value="delete"> --}}
                           <button class="btn btn-sm btn-danger">Delete</button>
                       </form>
                   </td>
               </tr>
           @endforeach

       </tbody>
   </table>

   {{ $categories->withQueryString()->links() }}
@endsection
