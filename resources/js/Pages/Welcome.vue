<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { route } from 'ziggy-js';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome" />
    <div
        class="bg-gradient-to-br from-primary via-white to-primary-200 min-h-screen text-[#1F2937]"
    >
        <div
            class="relative flex min-h-screen flex-col items-center justify-center selection:bg-accent selection:text-white"
        >
            <div class="relative w-full max-w-2xl px-4 lg:max-w-6xl">
                <!-- HERO SECTION -->
                <header
                    class="flex flex-col items-center text-center py-8 gap-4"
                >
                    <svg
                        class="h-12 w-12 text-accent mb-1 animate-bounce-slow"
                        viewBox="0 0 62 65"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M61.8548 14.6253C61.8778 14.7102 61.8895 14.7978 61.8897 14.8858V28.5615C61.8898 28.737 61.8434 28.9095 61.7554 29.0614C61.6675 29.2132 61.5409 29.3392 61.3887 29.4265L49.9104 36.0351V49.1337C49.9104 49.4902 49.7209 49.8192 49.4118 49.9987L25.4519 63.7916C25.3971 63.8227 25.3372 63.8427 25.2774 63.8639C25.255 63.8714 25.2338 63.8851 25.2101 63.8913C25.0426 63.9354 24.8666 63.9354 24.6991 63.8913C24.6716 63.8838 24.6467 63.8689 24.6205 63.8589C24.5657 63.8389 24.5084 63.8215 24.456 63.7916L0.501061 49.9987C0.348882 49.9113 0.222437 49.7853 0.134469 49.6334C0.0465019 49.4816 0.000120578 49.3092 0 49.1337L0 8.10652C0 8.01678 0.0124642 7.92953 0.0348998 7.84477C0.0423783 7.8161 0.0598282 7.78993 0.0697995 7.76126C0.0884958 7.70891 0.105946 7.65531 0.133367 7.6067C0.152063 7.5743 0.179485 7.54812 0.20192 7.51821C0.230588 7.47832 0.256763 7.43719 0.290416 7.40229C0.319084 7.37362 0.356476 7.35243 0.388883 7.32751C0.425029 7.29759 0.457436 7.26518 0.498568 7.2415L12.4779 0.345059C12.6296 0.257786 12.8015 0.211853 12.9765 0.211853C13.1515 0.211853 13.3234 0.257786 13.475 0.345059L25.4531 7.2415H25.4556C25.4955 7.26643 25.5292 7.29759 25.5653 7.32626C25.5977 7.35119 25.6339 7.37362 25.6625 7.40104C25.6974 7.43719 25.7224 7.47832 25.7523 7.51821C25.7735 7.54812 25.8021 7.5743 25.8196 7.6067C25.8483 7.65656 25.8645 7.70891 25.8844 7.76126C25.8944 7.78993 25.9118 7.8161 25.9193 7.84602C25.9423 7.93096 25.954 8.01853 25.9542 8.10652V33.7317L35.9355 27.9844V14.8846C35.9355 14.7973 35.948 14.7088 35.9704 14.6253C35.9792 14.5954 35.9954 14.5692 36.0053 14.5405C36.0253 14.4882 36.0427 14.4346 36.0702 14.386C36.0888 14.3536 36.1163 14.3274 36.1375 14.2975C36.1674 14.2576 36.1923 14.2165 36.2272 14.1816C36.2559 14.1529 36.292 14.1317 36.3244 14.1068C36.3618 14.0769 36.3942 14.0445 36.4341 14.0208L48.4147 7.12434C48.5663 7.03694 48.7383 6.99094 48.9133 6.99094C49.0883 6.99094 49.2602 7.03694 49.4118 7.12434L61.3899 14.0208C61.4323 14.0457 61.4647 14.0769 61.5021 14.1055C61.5333 14.1305 61.5694 14.1529 61.5981 14.1803C61.633 14.2165 61.6579 14.2576 61.6878 14.2975C61.7103 14.3274 61.7377 14.3536 61.7551 14.386C61.7838 14.4346 61.8 14.4882 61.8199 14.5405C61.8312 14.5692 61.8474 14.5954 61.8548 14.6253ZM59.893 27.9844V16.6121L55.7013 19.0252L49.9104 22.3593V33.7317L59.8942 27.9844H59.893ZM47.9149 48.5566V37.1768L42.2187 40.4299L25.953 49.7133V61.2003L47.9149 48.5566ZM1.99677 9.83281V48.5566L23.9562 61.199V49.7145L12.4841 43.2219L12.4804 43.2194L12.4754 43.2169C12.4368 43.1945 12.4044 43.1621 12.3682 43.1347C12.3371 43.1097 12.3009 43.0898 12.2735 43.0624L12.271 43.0586C12.2386 43.0275 12.2162 42.9888 12.1887 42.9539C12.1638 42.9203 12.1339 42.8916 12.114 42.8567L12.1127 42.853C12.0903 42.8156 12.0766 42.7707 12.0604 42.7283C12.0442 42.6909 12.023 42.656 12.013 42.6161C12.0005 42.5688 11.998 42.5177 11.9931 42.4691C11.9881 42.4317 11.9781 42.3943 11.9781 42.3569V15.5801L6.18848 12.2446L1.99677 9.83281ZM12.9777 2.36177L2.99764 8.10652L12.9752 13.8513L22.9541 8.10527L12.9752 2.36177H12.9777ZM18.1678 38.2138L23.9574 34.8809V9.83281L19.7657 12.2459L13.9749 15.5801V40.6281L18.1678 38.2138ZM48.9133 9.14105L38.9344 14.8858L48.9133 20.6305L58.8909 14.8846L48.9133 9.14105ZM47.9149 22.3593L42.124 19.0252L37.9323 16.6121V27.9844L43.7219 31.3174L47.9149 33.7317V22.3593ZM24.9533 47.987L39.59 39.631L46.9065 35.4555L36.9352 29.7145L25.4544 36.3242L14.9907 42.3482L24.9533 47.987Z"
                            fill="currentColor"
                        />
                    </svg>
                    <h1
                        class="text-3xl sm:text-4xl font-display font-bold bg-gradient-to-r from-accent to-accent-hover bg-clip-text text-transparent drop-shadow-lg animate-fade-in"
                    >
                        Welcome to Leonard
                    </h1>
                    <p
                        class="mt-2 text-base sm:text-lg text-[#6B7280] max-w-2xl animate-fade-in delay-100 font-body"
                    >
                        Effortlessly manage your transportation records,
                        suppliers, and profits with a modern, intuitive
                        dashboard. <br />
                        <span class="font-semibold text-accent"
                            >Fast. Reliable. Beautiful.</span
                        >
                    </p>
                    <div
                        class="mt-4 flex flex-col sm:flex-row gap-3 animate-fade-in delay-200"
                    >
                        <Link
                            :href="
                                route(
                                    $page.props.auth?.user
                                        ? 'dashboard'
                                        : 'login'
                                )
                            "
                            class="rounded-xl px-6 py-2.5 bg-gradient-to-r from-accent to-accent-hover text-white font-semibold text-base shadow-md transition hover:from-accent-hover hover:to-accent-dark hover:shadow-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-accent font-body"
                        >
                            {{
                                $page.props.auth?.user
                                    ? "Go to Dashboard"
                                    : "Get Started"
                            }}
                        </Link>
                        <a
                            href="#features"
                            class="rounded-xl px-6 py-2.5 bg-white text-accent font-semibold text-base shadow-md border-2 border-accent transition hover:bg-accent hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-accent font-body"
                        >
                            Learn More
                        </a>
                    </div>
                </header>

                <!-- FEATURES SECTION -->
                <main id="features" class="mt-6 mb-8">
                    <div class="w-full flex flex-col gap-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Feature Card 1 -->
                            <div
                                class="flex flex-col items-center bg-white/80 rounded-xl shadow-md p-4 border border-accent/10 hover:shadow-lg hover:-translate-y-1 transition-all"
                            >
                                <svg
                                    class="h-8 w-8 text-accent mb-2"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 17v-2a4 4 0 014-4h4m0 0V7a4 4 0 00-8 0v4m8 0a4 4 0 01-8 0"
                                    />
                                </svg>
                                <h2 class="text-lg font-display font-semibold mb-1.5 text-[#1F2937]">
                                    Smart Record Management
                                </h2>
                                <p class="text-sm text-[#6B7280] font-body text-center">
                                    Create, edit, and track all your
                                    transportation records in one place. Enjoy
                                    real-time updates and powerful filtering.
                                </p>
                            </div>
                            <!-- Feature Card 2 -->
                            <div
                                class="flex flex-col items-center bg-white/80 rounded-xl shadow-md p-4 border border-accent/10 hover:shadow-lg hover:-translate-y-1 transition-all"
                            >
                                <svg
                                    class="h-8 w-8 text-accent mb-2"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M17 9V7a5 5 0 00-10 0v2a2 2 0 00-2 2v7a2 2 0 002 2h12a2 2 0 002-2v-7a2 2 0 00-2-2z"
                                    />
                                </svg>
                                <h2 class="text-lg font-display font-semibold mb-1.5 text-[#1F2937]">
                                    Supplier Insights
                                </h2>
                                <p class="text-sm text-[#6B7280] font-body text-center">
                                    Manage suppliers with ease. View
                                    performance, add new partners, and keep your
                                    business relationships thriving.
                                </p>
                            </div>
                            <!-- Feature Card 3 -->
                            <div
                                class="flex flex-col items-center bg-white/80 rounded-xl shadow-md p-4 border border-accent/10 hover:shadow-lg hover:-translate-y-1 transition-all"
                            >
                                <svg
                                    class="h-8 w-8 text-accent mb-2"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 10c-4.418 0-8-1.79-8-4V7a4 4 0 014-4h8a4 4 0 014 4v7c0 2.21-3.582 4-8 4z"
                                    />
                                </svg>
                                <h2 class="text-lg font-display font-semibold mb-1.5 text-[#1F2937]">
                                    Profit Analytics
                                </h2>
                                <p class="text-sm text-[#6B7280] font-body text-center">
                                    Visualize your profits and trends. Instantly
                                    see total and average profits, and make
                                    data-driven decisions for your business.
                                </p>
                            </div>
                        </div>
                        <!-- Call to Action -->
                        <div class="flex flex-col items-center mt-6">
                            <h3 class="text-xl font-display font-semibold mb-1.5 text-accent">
                                Ready to get started?
                            </h3>
                            <p class="text-sm text-[#6B7280] mb-3 font-body">
                                Sign up or log in to experience the next
                                generation of transportation management.
                            </p>
                            <div class="flex gap-3">
                                <Link
                                    :href="
                                        route(
                                            $page.props.auth?.user
                                                ? 'dashboard'
                                                : 'register'
                                        )
                                    "
                                    class="rounded-xl px-6 py-2.5 bg-gradient-to-r from-accent to-accent-hover text-white font-semibold text-base shadow-md transition hover:from-accent-hover hover:to-accent-dark hover:shadow-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-accent font-body"
                                >
                                    {{
                                        $page.props.auth?.user
                                            ? "Go to Dashboard"
                                            : "Create Account"
                                    }}
                                </Link>
                                <Link
                                    v-if="!$page.props.auth?.user"
                                    :href="route('login')"
                                    class="rounded-xl px-6 py-2.5 bg-white text-accent font-semibold text-base shadow-md border-2 border-accent transition hover:bg-accent hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-accent font-body"
                                >
                                    Log In
                                </Link>
                            </div>
                        </div>
                    </div>
                </main>

                <footer class="py-6 text-center text-xs text-[#9CA3AF] mt-6 font-body">
                    &copy; {{ new Date().getFullYear() }} Leonard. Built with
                    Laravel v{{ laravelVersion }} & PHP v{{ phpVersion }}.
                </footer>
            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: none;
    }
}
@keyframes bounce-slow {
    0%,
    100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}
.animate-fade-in {
    animation: fade-in 1s cubic-bezier(0.4, 0, 0.2, 1) both;
}
.animate-bounce-slow {
    animation: bounce-slow 2.5s infinite;
}
</style>
