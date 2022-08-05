<?php

namespace Nodus\Packages\OpenApiGenerator;

use Closure;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Nodus\Packages\OpenApiGenerator\Objects\Contact;
use Nodus\Packages\OpenApiGenerator\Objects\Info;
use Nodus\Packages\OpenApiGenerator\Objects\License;
use Nodus\Packages\OpenApiGenerator\Objects\OpenApi;
use Nodus\Packages\OpenApiGenerator\Objects\Operation;
use Nodus\Packages\OpenApiGenerator\Objects\Paths;
use Nodus\Packages\OpenApiGenerator\Objects\Responses;
use ReflectionClass;
use Symfony\Component\Yaml\Yaml;

class OpenApiService
{
    public const OPENAPI_VERSION = '3.0.0';

    /**
     * Returns openapi specification in yaml
     *
     * @return string OpenApi yaml specification
     */
    public function generateYaml(): string
    {
        return Yaml::dump($this->generate()->toArray());
    }

    /**
     * Returns openapi specification in json
     *
     * @return string OpenApi json specification
     */
    public function generateJson(): string
    {
        return json_encode($this->generate()->toArray());
    }

    /**
     * Returns an OpenApi object
     *
     * @return OpenApi
     */
    private function generate(): OpenApi
    {
        $openApi = new OpenApi(
            self::OPENAPI_VERSION,
            $this->generateInfo(),
            $this->generatePaths(),
        );
        $openApi->servers = $this->generateServers();

        return $openApi;
    }

    /**
     * Returns an Info object
     *
     * @return Info
     */
    protected function generateInfo(): Info
    {
        $info = new Info(
            config('openapi-generator.fields.info.title', config('app.name')),
            config('openapi-generator.fields.info.version', $this->getComposer('version')),
        );
        $info->description = config('openapi-generator.fields.info.description', $this->getComposer('description'));
        $info->termsOfService = config('openapi-generator.fields.info.termsOfService');
        $info->contact = $this->generateContact();
        $info->license = $this->generateLicence();

        return $info;
    }

    /**
     * Returns an Contact object
     *
     * @return Contact|null
     */
    protected function generateContact(): Contact|null
    {
        return new Contact(
            $this->getComposer('authors')[0]->name ?? null,
            $this->getComposer('authors')[0]->homepage ?? null,
            $this->getComposer('authors')[0]->email ?? null,
        );
    }

    /**
     * Generate the pahts, based on laravel routes
     *
     * @return Paths
     */
    protected function generatePaths()
    {
        $paths = [];
        foreach ($this->getRoutes() as $route) {
            $path = Str::replace(config('openapi-generator.routes.prefix'), '', Str::start($route->uri(), '/'));
            $paths[$path] = array_merge($paths[$path] ?? [], $this->generatePath($route));
        }

        return new Paths($paths);
    }


    protected function generatePath(\Illuminate\Routing\Route $route)
    {
        $ref = new ReflectionClass($route->getControllerClass());
        $doc = $this->parseDocBlock($ref->getMethod($route->getActionMethod())->getDocComment());

        $path = [];
        foreach ($route->methods() as $method) {
            if (in_array($method, config('openapi-generator.routes.methods', []))) {
                if (method_exists($this, 'generatePathFor' . Str::ucfirst($method))) {
                    $operationObject = $this->{'generatePathFor' . Str::ucfirst($method)}($route, $method, $doc);
                } else {
                    $operationObject = new Operation($this->generateResponses($route));
                    $operationObject->tags = [explode('/', $route->uri())[2]];
                    $operationObject->summary = $this->getTranslationForRouteSummary($route, $method);
                    $operationObject->description = $this->getTranslationForRouteSummary($route, $method);
                    $operationObject->operationId = $route->getName() ?? md5(implode(',', $route->methods()) . $route->uri());
                    $operationObject->parameters = $this->generateParameters($route);
                }

                $path[Str::lower($method)] = $operationObject;
            }
        }

        return $path;
    }

    protected function generateParameters(\Illuminate\Routing\Route $route)
    {
        $parameters = [];
        foreach ($route->parameterNames() as $parameterName) {
            $parameters[] = [
                'in'          => 'path',
                'name'        => $parameterName,
                'description' => 'ToDo',
                'required'    => true, // ToDo: Optionale Parameter supporten
                'schema'      => [
                    'type' => 'string',
                ],
            ];
        }

        return $parameters;
    }

    /**
     * Returns an License object
     *
     * @return License|null
     */
    protected function generateLicence(): License|null
    {
        if (config('openapi-generator.fields.info.license') !== null) {
            return new License(
                config('openapi-generator.fields.info.license.name'),
                config('openapi-generator.fields.info.license.url'),
            );
        }

        return null;
    }

    protected function generateServers()
    {
        return config('openapi-generator.fields.servers', []);
    }

    /**
     *  ToDo: Auslagern
     */
    private function getComposer(string $key = null)
    {
        $composer = json_decode(File::get(base_path('composer.json')));
        if ($key === null) {
            return $composer;
        }

        return $composer->$key;
    }

    private function parseDocBlock(bool|string $string)
    {
        if (preg_match_all('/\* @([a-z-]+) ([A-Za-z $.,]+)/', $string, $matches, PREG_SET_ORDER) !== false) {
            foreach ($matches as $match) {
                $tags[$match[1]][] = $match[2];
            }
        }

        if (preg_match_all('/\* ([a-zA-ZäöüÄÖÜ\-_ ,.]+)/', $string, $matches, PREG_SET_ORDER) !== false) {
            $desc = '';
            foreach ($matches as $match) {
                $desc .= $match[1];
            }
        }

        return [
            'desc' => $desc,
            'tags' => $tags,
        ];
    }

    protected function getRoutes(): array
    {
        $routes = [];
        foreach (Route::getRoutes()->getRoutes() as $route) {
            /**
             * Exclude Closure Routes
             */
            if ($route->action['uses'] instanceof Closure) {
                continue;
            }

            if (Str::startsWith($route->uri(), config('openapi-generator.routes.excluded', []))) {
                continue;
            }

            if (config('openapi-generator.routes.prefix') !== null) {
                if (Str::startsWith($route->uri(), config('openapi-generator.routes.prefix'))) {
                    $routes[] = $route;
                }
            } else {
                $routes[] = $route;
            }
        }

        return $routes;
    }

    protected function generateResponses(\Illuminate\Routing\Route $route)
    {
        $responses = new Responses();
        $responses->{200} = [
            'description' => 'OK',
        ];
        $responses->{401} = [
            'description' => 'Unauthorized',
        ];
        if (!empty($route->parameterNames())) {
            $responses->{404} = [
                'description' => 'Requestet object was not found',
            ];
        }
        if (Str::contains('POST', $route->methods()) || Str::contains('PUT', $route->methods())) {
            $responses->{422} = [
                'description' => 'Validation error',
            ];
        }

        return $responses;
    }


    protected function getTranslationForRouteSummary(\Illuminate\Routing\Route $route, string $method)
    {
        return $this->getTranslationForRoute($route, $method, 'summary');
    }

    protected function getTranslationForRouteDescription(\Illuminate\Routing\Route $route, string $method)
    {
        return $this->getTranslationForRoute($route, $method, 'description');
    }

    protected function getTranslationForRoute(\Illuminate\Routing\Route $route, string $method, string $suffix)
    {
        $prefix = config('openapi-generator.translation.prefix', 'routes') . '.';
        $translationString = $route->getName() . '.' . Str::lower($method);
        $translation = trans($prefix . $translationString . '.' . $suffix);
        if ($translation == $prefix . $translationString . '.' . $suffix) {
            return $translationString;
        }

        return $translation;
    }

}