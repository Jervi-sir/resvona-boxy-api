<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <a href="{{ route('users.add') }}">create Users</a>
                </button>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <a href="{{ route('users.hardCreatePage') }}">manually creating Users</a>
                </button>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <a href="https://boxydz.netlify.app/" target="_blank">goto site</a>
                </button>
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    <a href="{{ route('dashboard') }}">dashboard</a>
                </button>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                          <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                              <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                  <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                      username
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                      password
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                      link
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                      created at
                                    </th>
                                  </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach (\App\Models\User::orderBy('id', 'DESC')->get() as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                          <div class="flex items-center">
                                            <div class="ml-4">
                                              <div class="text-sm font-medium text-gray-900">
                                                {{$user->name}}
                                              </div>
                                            </div>
                                          </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                          <div class="text-sm text-gray-900">{{$user->passNoHash}}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                          <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{$user->uuid}}
                                          </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{$user->created_at->isoFormat('dddd-D MM YYYY')}}
                                        </td>
                                      </tr>
                                    @endforeach
                                  
                      
                                  <!-- More people... -->
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
