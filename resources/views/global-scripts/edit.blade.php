<x-app-layout>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <section class="card">
        <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Global Header, Body & Footer Scripts</h5>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="alert alert-info">
                These scripts are added to every public website page.
            </div>

            <form method="POST" action="{{ route('global-scripts.update') }}">
                @csrf
                @method('PUT')

                <div class="row">
                    @include('seo-meta.partials.script-fields', ['scriptSource' => $globalScripts])
                </div>

                <button type="submit" class="btn btn-primary">Save Global Scripts</button>
            </form>
        </div>
    </section>
</x-app-layout>
