<x-app-layout>
    <!-- Header -->
    <div class="bg-gradient-to-br from-[#313647] to-[#435663]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-xl sm:text-2xl font-bold text-[#FFF8D4]">
                Privacy Policy
            </h1>
        </div>
    </div>

    <!-- Gelber Streifen -->
    <div class="bg-[#FFF8D4] py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-[#313647]">Information about data processing on this website</p>
        </div>
    </div>

    <!-- Hauptinhalt -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">

                    <section class="mb-8">
                        <h2 class="text-lg font-semibold text-[#313647] mb-4">1. Overview</h2>
                        <p class="text-[#435663]">
                            This privacy policy explains what personal data is collected when you visit the Archaeoludic Archive and how it is processed. I take the protection of your personal data seriously and treat it confidentially in accordance with the applicable data protection regulations (GDPR).
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-lg font-semibold text-[#313647] mb-4">2. Responsible party</h2>
                        <p class="text-[#435663]">
                            Sebastian Hageneuer<br>
                            Berlin, Germany<br>
                            Email: <span id="email-address-1"></span>
                            <noscript>[JavaScript required to display email]</noscript>
                        </p>
                        <script>
                            (function() {
                                var u = 's.hageneuer';
                                var d = 'outlook.de';
                                var e = document.getElementById('email-address-1');
                                e.innerHTML = '<a href="mailto:' + u + '@' + d + '" class="text-[#435663] hover:text-[#A3B087] underline">' + u + '@' + d + '</a>';
                            })();
                        </script>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-lg font-semibold text-[#313647] mb-4">3. Data collection on this website</h2>

                        <h3 class="font-medium text-[#313647] mt-4 mb-2">Server log files</h3>
                        <p class="text-[#435663] mb-4">
                            The hosting provider automatically collects and stores information in server log files, which your browser automatically transmits. These are: browser type and version, operating system, referrer URL, hostname of the accessing computer, and time of the server request. This data cannot be assigned to specific persons. This data is not merged with other data sources.
                        </p>

                        <h3 class="font-medium text-[#313647] mt-4 mb-2">Contact form</h3>
                        <p class="text-[#435663] mb-4">
                            If you send inquiries via the contact form, your details from the form, including the contact data you provide there, will be stored for the purpose of processing the inquiry and in case of follow-up questions. This data will not be passed on without your consent.
                        </p>

                        <h3 class="font-medium text-[#313647] mt-4 mb-2">User accounts</h3>
                        <p class="text-[#435663]">
                            If you register for an account, we store your email address and encrypted password. This data is used solely for authentication purposes and to enable you to contribute to the database.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-lg font-semibold text-[#313647] mb-4">4. External services</h2>

                        <h3 class="font-medium text-[#313647] mt-4 mb-2">IGDB API</h3>
                        <p class="text-[#435663] mb-4">
                            This website uses the IGDB API to retrieve game information such as cover images, descriptions, and platform data. When you view a game page, a request may be made to IGDB servers. Please refer to <a href="https://www.igdb.com/privacy_policy" target="_blank" class="text-[#435663] hover:text-[#A3B087] underline">IGDB's Privacy Policy</a> for more information.
                        </p>

                        <h3 class="font-medium text-[#313647] mt-4 mb-2">External favicons</h3>
                        <p class="text-[#435663]">
                            This website displays favicons from external services (Steam, GOG, Wikidata, IGDB) to indicate linked data sources. Loading these images may result in requests to the respective servers.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-lg font-semibold text-[#313647] mb-4">5. Cookies</h2>
                        <p class="text-[#435663]">
                            This website uses only technically necessary cookies for session management and authentication. No tracking or analytics cookies are used. These essential cookies are required for the website to function properly and cannot be disabled.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-lg font-semibold text-[#313647] mb-4">6. Your rights</h2>
                        <p class="text-[#435663] mb-4">
                            Under the GDPR, you have the following rights:
                        </p>
                        <ul class="list-disc list-outside ml-6 text-[#435663] space-y-1">
                            <li>Right to access your personal data</li>
                            <li>Right to rectification of inaccurate data</li>
                            <li>Right to erasure of your data</li>
                            <li>Right to restriction of processing</li>
                            <li>Right to data portability</li>
                            <li>Right to object to processing</li>
                        </ul>
                        <p class="text-[#435663] mt-4">
                            To exercise these rights, please contact me via email: <span id="email-address-2"></span>
                            <noscript>[JavaScript required to display email]</noscript>
                        </p>
                        <script>
                            (function() {
                                var u = 's.hageneuer';
                                var d = 'outlook.de';
                                var e = document.getElementById('email-address-2');
                                e.innerHTML = '<a href="mailto:' + u + '@' + d + '" class="text-[#435663] hover:text-[#A3B087] underline">' + u + '@' + d + '</a>';
                            })();
                        </script>
                    </section>

                    <section>
                        <h2 class="text-lg font-semibold text-[#313647] mb-4">7. Changes to this policy</h2>
                        <p class="text-[#435663]">
                            This privacy policy may be updated occasionally. The current version is always available on this page.
                        </p>
                        <p class="text-sm text-gray-400 mt-4">
                            Last updated: {{ config('version.date') }}
                        </p>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
