@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-white dark:text-gray-900 focus:border-[#1a237e]  dark:focus:border-[#1a237e]  focus:ring-[#1a237e]  dark:focus:ring-[#1a237e]  rounded-md shadow-sm']) !!}>
