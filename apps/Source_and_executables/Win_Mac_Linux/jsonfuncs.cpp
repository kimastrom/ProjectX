// Class for parsing json-data

// Includes all the importen libs (in qt)
// that we need to use for this class to work
#include "jsonfuncs.h"
#include <QVariantList>
#include <QVariant>
#include <QString>
#include <libs/code/qjson/parser.h>

// Parse given data with the json-parser, and return
// an object with parsed json-data
QVariantList JsonFuncs::GetJsonObject(QByteArray a_jsonData)
{
    QJson::Parser parser;
    QVariantList jsonObjectResult = parser.parse(a_jsonData).toList();
    return jsonObjectResult;
}

// Get json-data with code for a specific snippet
QString JsonFuncs::GetSnippetCode(QVariantList a_jsonObject)
{
    QString codeData;
    foreach(QVariant record, a_jsonObject)
    {
        QVariantMap map = record.toMap();
        codeData = map.value("code").toString();
    }
    return codeData;
}
