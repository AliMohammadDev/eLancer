<x-app-layout>
    <form action="{{ route('client.projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('client.projects._form')
        <div class="col-xl-12">
            <button type="submit" class="button ripple-effect big margin-top-30"><i class="icon-feather-plus"></i> Post a
                Job</button>
        </div>
    </form>
</x-app-layout>
