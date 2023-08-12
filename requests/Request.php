<?php

namespace app\requests;

use yii\web\Request as WebRequest;

class Request
{
    private WebRequest $request;

    public function __construct()
    {
        $this->request = \Yii::$app->request;
    }

    public function isPost(): bool
    {
        return $this->request->isPost;
    }

    public function isGet(): bool
    {
        return $this->request->isGet;
    }

    /**
     * @throws \Exception
     */
    public function getPostParamOrFail(?string $key = null, ?string $message = null): mixed
    {
        $postParam = $this->getPostParam($key);
        if (is_null($postParam)) {
            throw new \Exception($message ?? "Not found post parameter by key {$key}");
        }
        return $postParam;
    }

    /**
     * @throws \Exception
     */
    public function getGetParamOrFail(?string $key = null, ?string $message = null): mixed
    {
        $getParam = $this->getGetParam($key);
        if (is_null($getParam)) {
            throw new \Exception($message ?? "Not found get parameter by key {$key}");
        }
        return $getParam;
    }

    public function getPostParam(?string $key = null, mixed $default = null): mixed
    {
        return $this->request->post($key, $default);
    }

    public function getGetParam(?string $key = null, mixed $default = null): mixed
    {
        return $this->request->get($key, $default);
    }
}
