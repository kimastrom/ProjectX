// Class (header-file) for getting the api-adress from settings

// Includes all the importen libs (in qt)
// that we need to use for this class to work
#include "settingsfuncs.h"
#include <QString>
#include <QSettings>
#include <QVariant>

// Get the api-adress from settings.
QString SettingsFuncs::GetApiUrl()
{    
    QVariant apiUrl;
    QSettings settings("ProjectX", "Snippt");
    settings.beginGroup("SnipptSettings");
    apiUrl = settings.value("apiurl");
    QString apiUrlConv = apiUrl.toString();
    settings.endGroup();

    return apiUrlConv;
}
